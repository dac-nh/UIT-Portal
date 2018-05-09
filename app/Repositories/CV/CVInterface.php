<?php
namespace App\Repositories\CV;

interface CVInterface
{
    public function insert($student_id, $filename);
    public function findById($id);
    public function findBy($field, $value);
    public function findMaxID();
    public function deleteCV($id);
    public function editName($id,$newName);
}