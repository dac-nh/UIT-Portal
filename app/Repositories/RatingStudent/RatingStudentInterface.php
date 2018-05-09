<?php

namespace App\Repositories\RatingStudent;

interface RatingStudentInterface
{
    public function findById($id);

    public function findRatingStudentBy($field, $value);

    public function findListRatingStudentByStudentId($value);

    public function findListRatingStudentById($value);

    public function findListLecturerByStudentId($studentId);

    public function findListLecturerByLecturerId($lecturerId);

    public function findListProjectCompanyByStudentId($studentId);

    public function insertRatingStudent($body, $rating, $lecturer_id, $student_id, $type);
}