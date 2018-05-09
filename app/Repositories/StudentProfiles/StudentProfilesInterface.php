<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:41 AM
 */
namespace App\Repositories\StudentProfiles;

use Illuminate\Http\Request;

interface StudentProfilesInterface
{
    public function findById($id);

    public function updateStudentWhenApplyProject($id, $gpa, $phone, $skypeid);

    public function getMyRank($student_id);

    public function searchStudentList($name, $universityName, $ratingFrom, $ratingTo);

    // 09-12-2016: Dac: update user detail
    public function updateStudentProfile(Request $request, $id);

    public function updateStudentIntro(Request $request, $id);

    public function insertStudentProfile($id, $name);

    public function updateRating($rating, $id, $type);
}