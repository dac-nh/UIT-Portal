<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserApplyProject
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $student_id
 * @property string $student_name
 * @property boolean $student_rating
 * @property boolean $result
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $students
 * @property-read \App\Models\StudentProfile $studentprofile
 * @property-read \App\Models\Project $project
 * @property integer cv_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereStudentName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereStudentRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $cv_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserApplyProject whereCvId($value)
 */
class UserApplyProject extends Model
{
    protected $table = 'user_apply_project';

    public function students()
    {
        return $this->belongsTo('App\Models\User','student_id','id');
    }
    public function studentprofile(){
        return $this->belongsTo('App\Models\StudentProfile','student_id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
