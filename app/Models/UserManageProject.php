<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserManageProject
 *
 * @property integer $project_id
 * @property integer $user_id
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserManageProject whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserManageProject whereUserId($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserManageProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserManageProject whereUpdatedAt($value)
 */
class UserManageProject extends Model
{
    protected $table = 'user_manage_project';

    public function user(){
        return $this->belongsTo('App\Models\User','id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
