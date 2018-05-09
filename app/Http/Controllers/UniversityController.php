<?php
namespace App\Http\Controllers;

use App\Repositories\University\UniversityInterface;

/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 12/16/2016
 * Time: 2:05 PM
 * @property UniversityInterface university
 */
class UniversityController extends Controller
{
    /**
     * @param UniversityInterface $university
     */
    public function __construct(UniversityInterface $university)
    {
        $this->university = $university;
    }

    public function getListUniversity()
    {
        if (!$university = $this->university->getListUniversity())
            return null;
        return $university;
    }
}