<?php
namespace App\Repositories\University;

interface UniversityInterface
{
    public function findByID($id);

    public function getInfoCurrentUser($currentUniversity);

    public function getListUniversity();
}