<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
/**
 * App\Models\Project
 *
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property boolean $type
 * @property integer $address_id
 * @property boolean $length
 * @property boolean $need_min
 * @property boolean $need_max
 * @property string $intro
 * @property string $requirement
 * @property string $plus_point
 * @property boolean $has_extra_file
 * @property integer $num_of_applied
 * @property integer $num_of_joined
 * @property integer $created_by_id
 * @property string $created_by_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserApplyProject[] $applies
 * @property-read \App\Models\Company $companies
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereLength($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereNeedMin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereNeedMax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereRequirement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project wherePlusPoint($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereHasExtraFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereNumOfApplied($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereNumOfJoined($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCreatedById($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCreatedByName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereContactEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $start_date
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereStartDate($value)
 * @property integer $status
 * @property boolean $is_fulltime
 * @property integer $publish_date
 * @property string $contact_email
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereIsFulltime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project wherePublishDate($value)
 * @property string $avatar
 * @property integer $address
 * @property integer $created_by_agent_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project whereCreatedByAgentId($value)
 */
class Project extends Model
{
    protected $table = 'project';

    public function applies(){
        return $this->hasMany('App\Models\UserApplyProject');
    }
    public function companies(){
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }
    public function getCompanyLogo(){
        return Storage::url('company/logo/'.$this->company_id.'.png');
    }
}
