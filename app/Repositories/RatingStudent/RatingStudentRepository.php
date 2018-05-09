<?php
namespace App\Repositories\RatingStudent;

use App\Libraries\GeneralConstant;
use App\Models\RatingStudent;
use App\Repositories\StudentProfiles\StudentProfilesInterface;
use DB;
use League\Flysystem\Exception;
use Log;

/**
 * @property StudentProfilesInterface studentProfiles
 */
class RatingStudentRepository implements RatingStudentInterface
{
    public $ratingStudent;

    /**
     * RatingStudentRepository constructor.
     * @param RatingStudent $ratingStudent
     * @param StudentProfilesInterface $studentProfiles
     */
    function __construct(RatingStudent $ratingStudent, StudentProfilesInterface $studentProfiles)
    {
        $this->ratingStudent = $ratingStudent;
        $this->studentProfiles = $studentProfiles;
    }

    /**
     * @param $id
     * @return RatingStudent|RatingStudentRepository|bool
     */
    public function findById($id)
    {
        try {
            $RatingStudent = $this->ratingStudent->find($id);
        } catch (Exception $exception) {
            Log::info('[RatingStudent REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $RatingStudent;
    }

    /**
     * @param $field
     * @param $value
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findRatingStudentBy($field, $value)
    {
        try {
            $RatingStudent = $this->ratingStudent->where($field, $value)->get();
        } catch (Exception $exception) {
            Log::info('[RatingStudent REPOSITORY] BUG WHILE QUERY FIND BY FIELD and VALUE');
            return false;
        }
        return $RatingStudent;
    }

    /**
     * @param $value
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findListRatingStudentByStudentId($value)
    {
        try {
            $RatingStudent = $this->ratingStudent->where('student_id', $value)->get();
        } catch (Exception $exception) {
            Log::info('[RatingStudent REPOSITORY] BUG WHILE QUERY FIND BY FIELD and VALUE');
            return false;
        }
        return $RatingStudent;
    }

    // 25-11-2016: Dac: find list RatingStudent by id
    /**
     * @param $value
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findListRatingStudentById($value)
    {
        try {
            $RatingStudentList = $this->ratingStudent->whereIn('id', $value)->get();
        } catch (Exception $exception) {
            Log::info('[RatingStudent REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
        return $RatingStudentList;
    }

    /**
     * @param $lecturerId
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findListLecturerByLecturerId($lecturerId)
    {
        try {
            return $this->ratingStudent
                ->join('user as user', 'rating_student.user_id', 'user.id')
                ->join('university as university', 'user.university_id', 'university.id')
                ->select('user.name', 'rating_student.*', 'university.name as university_name', 'university.url')
                ->where('user_id', $lecturerId)->get();
        } catch (\Exception $exception) {
            Log::info('[RatingStudent REPOSITORY] BUG WHILE QUERY FIND BY ID');
            return false;
        }
    }

    // 25-11-2016: Dac: get lecturer information for user_detail
    /**
     * @param $studentId
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findListLecturerByStudentId($studentId)
    {
        try {
            return $this->ratingStudent
                ->join('user as user', 'rating_student.user_id', '=', 'user.id')
                ->join('university as university', 'user.university_id', '=', 'university.id')
                ->select('user.name', 'rating_student.*', 'university.name as university_name', 'university.url')
                ->where('rating_student.student_id', $studentId)->where('rating_student.type', GeneralConstant::LECTURER_ROLE)->get();
        } catch (\Exception $exception) {
            Log::info('[findListLecturerByStudentId REPOSITORY] BUG WHILE QUERY FIND BY student id ' . $exception);
            return false;
        }
    }

    /**
     * @param $studentId
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findListProjectCompanyByStudentId($studentId)
    {
        try {
            return $this->ratingStudent
                ->join('project as project', 'rating_student.user_id', '=', 'project.id')
                ->join('company as company', 'project.company_id', '=', 'company.id')
                ->select('project.name as project_name', 'rating_student.*', 'company.name as company_name', 'company.avatar')
                ->where('rating_student.student_id', $studentId)->where('rating_student.type', GeneralConstant::COMPANY_ROLE)->get();
        } catch (\Exception $exception) {
            Log::info('[findListLecturerByStudentId REPOSITORY] BUG WHILE QUERY FIND BY student id ' . $exception);
            return false;
        }
    }

    /**
     * @param $body
     * @param $rating
     * @param $lecturer_id
     * @param $student_id
     * @param $type
     * @return RatingStudent|bool
     */
    public function insertRatingStudent($body, $rating, $lecturer_id, $student_id, $type)
    {
        $ratingStudent = new RatingStudent();
        if (DB::transaction(function () use ($ratingStudent, $body, $rating, $lecturer_id, $student_id, $type) {
            try {
                if ($studentProfile = $this->studentProfiles->updateRating($rating, $student_id, GeneralConstant::LECTURER_ROLE)) {

                    $ratingStudent->body = $body;
                    $ratingStudent->rating = $rating;
                    $ratingStudent->user_id = $lecturer_id;
                    $ratingStudent->student_id = $student_id;
                    $ratingStudent->type = $type;
                    $ratingStudent->save();
                    return true;
                }
                return false;
            } catch (\Exception $exception) {
                Log::info('[LECTURE RATE STUDENT] BUG WHILE INSERT LECTURE RATE STUDENT WITH: '.$exception);
                return false;
            }
        })
        )
            return $ratingStudent;
        return false;
    }
}
