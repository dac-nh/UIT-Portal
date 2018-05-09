<?php

namespace App\Models;

use App\Libraries\GeneralConstant;
use File;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * App\Models\StudentProfiles
 *
 * @property integer $id
 * @property string $full_name
 * @property string $birthday
 * @property boolean $is_female
 * @property string $university_name
 * @property string $faculty_name
 * @property string $major_name
 * @property string $academic_year
 * @property boolean $gpa
 * @property string $intro
 * @property integer $address_id
 * @property string $phone
 * @property string $skype_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserApplyProject[] $applies
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereFullName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereIsFemale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereUniversityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereFacultyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereMajorName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereAcademicYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereGpa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereSkypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CV[] $cvs
 * @property string $address
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereAddress($value)
 * @property boolean $rating
 * @property integer $total_rate
 * @property integer $num_rate
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereTotalRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StudentProfile whereNumRate($value)
 */
class StudentProfile extends Model
{
    protected $table = 'student_profile';

    public function user(){
        return $this->hasOne('App\Models\User','id','id');
    }
    public function applies(){
        return $this->hasMany('App\Models\UserApplyProject','student_id');
    }
    public function cvs(){
        return $this->hasMany('App\Models\Cv');
    }

    public function getStudentProfilesById($id){
        return static::findById($id);
    }
}
