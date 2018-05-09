<?php

namespace App\Repositories\University;

use App\Models\University;
use League\Flysystem\Exception;
use Log;

class UniversityRepository implements UniversityInterface
{
    public $university;

    function __construct(University $university)
    {
        $this->university = $university;
    }

    public function findByID($id)
    {
        try {
            $university = University::whereId($id)->select('name', 'url')->first();
        } catch (Exception $exception) {
            Log::info('[STUDENT PROFILES REPOSITORY] BUG while query find by ID');
            return false;
        }
        return $university;
    }

    public function getInfoCurrentUser($currentUniversity)
    {
        // TODO: Implement getInfoCurrentUser() method.
    }

    public function getListUniversity()
    {
        try {
            $universities = $this->university->all();
        } catch (Exception $exception) {
            Log::info('[GET LIST ALL UNIVERSITY] CATCH EXCEPTON: '.$exception);
            $universities = false;
        }
        return $universities;
    }
}
