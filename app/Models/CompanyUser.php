<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * 
 * User: Dark Wolf
 * Date: 12/20/2016
 * Time: 11:35 AM
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $user_id
 * @property boolean $role
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class CompanyUser extends Model
{
    protected $table = 'company_user';
}