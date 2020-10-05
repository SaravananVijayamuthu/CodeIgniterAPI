<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StudentModel;


class Student extends ResourceController
{
    use ResponseTrait;

    // get all student
    public function index(){
        $model = new StudentModel();
        $data['students'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
    
    // get single data from db
    public function show($name = null){
        $model = new StudentModel();
        $data = $model->where('name', $name)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Student found '.$name);
        }
    }

    // create
    public function create() {
        $model = new StudentModel();
        $data = [
            'rollno' => $this->request->getVar('rollno'),
            'name' => $this->request->getVar('name'),
            'dept'  => $this->request->getVar('dept'),
        ];
        $data = $this->request->getPost();
        $model->insert($data);
        $response = [
        'status'   => 201,
        'error'    => null,
        'messages' => [
            'success' => 'Student created successfully'
        ]
    ];
    return $this->respondCreated($data, 'product created');
    }

    // update or patch
    public function update($id = null)
    {
        $model = new StudentModel();
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        if (! $model->save($data))
        {
            return $this->fail($this->model->errors());
        }
        return $this->respond($data, 200, 'Student updated');
    }

    // delete
    public function delete($id = null){
        $model = new StudentModel();
        $data = $model->where('id', $id)->delete($id);
        if ($model->db->affectedRows() === 0)
        {
            return $this->failNotFound(sprintf(
                'product with id %d not found',
                $id
            ));
        }
        return $this->respondDeleted(['id' => $id], 'Student deleted');
    }

}