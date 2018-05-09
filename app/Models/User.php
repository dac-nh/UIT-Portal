<?php

namespace App\Models;

use App\Libraries\GeneralConstant;
use File;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property boolean $is_active
 * @property boolean $is_superuser
 * @property boolean $rating
 * @property integer $role_id
 * @property integer $university_id
 * @property integer $company_id
 * @property string $google_id
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\University $university
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserApplyProject[] $applies
 * @property-read \App\Models\StudentProfile $studentProfiles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIsSuperuser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUniversityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGoogleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property boolean $gender
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserApplyProject[] $UserApplyProject
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGender($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserApplyProject[] $userApplyProject
 * @property integer $count_wrong
 * @property string $log_in_timestamp
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCountWrong($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLogInTimestamp($value)
 * @property string $avatar
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAvatar($value)
 */
class User extends Authenticatable
{
    use Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function university()
    {
        return $this->belongsTo('App\Models\University', 'university_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function userApplyProject()
    {
        return $this->hasMany('App\Models\UserApplyProject');
    }

    public function studentProfiles()
    {
        return $this->hasOne('App\Models\StudentProfile', 'id', 'id');
    }

    public function isFemale()
    {
        return ($this->gender == GeneralConstant::IS_FEMALE);
    }

    public function isActive()
    {
        return ($this->is_active == GeneralConstant::IS_ACTIVE);
    }

    public function isSuperUser(){
        return ($this->role_id == GeneralConstant::SUPER_USER_ROLE);
    }

    public function isStudent()
    {
        return ($this->role_id == GeneralConstant::STUDENT_ROLE);
    }

    public function isLecture()
    {
        return ($this->role_id == GeneralConstant::LECTURER_ROLE);
    }
    public function isAgent()
    {
        return ($this->role_id == GeneralConstant::AGENT_ROLE);
    }
    public function isCompany()
    {
        return ($this->role_id == GeneralConstant::COMPANY_ROLE);
    }
}
