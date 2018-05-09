<?php

namespace App\Models;

use App\Libraries\GeneralConstant;
use Illuminate\Database\Eloquent\Model;

define('STUDENT_ID', '1');
define('LECTURER_ID', '2');
define('UNIVERSITY_AGENT_ID', '3');
define('COMPANY_EMPLOYEE_ID', '4');

/**
 * App\Models\University
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $address_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $student
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $lecturer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $universityAgent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $companyEmployee
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $address
 * @method static \Illuminate\Database\Query\Builder|\App\Models\University whereAddress($value)
 */
class University extends Model
{
    protected $table = 'university';

    public function student()
    {
        return $this->hasMany('App\Models\User')->where('role_id', GeneralConstant::STUDENT_ROLE);
    }
    public function lecturer()
    {
        return $this->hasMany('App\Models\User')->where('role_id', GeneralConstant::LECTURER_ROLE);
    }
    public function universityAgent()
    {
        return $this->hasMany('App\Models\User')->where('role_id', GeneralConstant::AGENT_ROLE);
    }
    public function companyEmployee()
    {
        return $this->hasMany('App\Models\User')->where('role_id', GeneralConstant::COMPANY_ROLE);
    }
}
