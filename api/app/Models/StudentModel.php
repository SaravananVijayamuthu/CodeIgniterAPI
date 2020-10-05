<?php 
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = "students";
    protected $id = "id";
    protected $allowedFields = ['rollno', 'name', 'dept'];
}
