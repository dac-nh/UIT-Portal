<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectUniversity
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $project_id
 * @property integer $university_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUniversity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUniversity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUniversity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUniversity whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUniversity whereUniversityId($value)
 * @mixin \Eloquent
 */
class ProjectUniversity extends Model
{
    protected $table = 'project_university';
}
