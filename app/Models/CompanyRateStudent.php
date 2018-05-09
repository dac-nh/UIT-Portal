<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * 
 * User: Dark Wolf
 * Date: 12/20/2016
 * Time: 11:09 AM
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $company_id
 * @property integer $student_id
 * @property string $body
 * @property boolean $rating
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyRateStudent whereUpdatedAt($value)
 */
class CompanyRateStudent extends Model
{
    protected $table = 'company_rate_student';
}