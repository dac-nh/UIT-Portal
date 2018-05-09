<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserJoinProject
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $student_id
 * @property string $start_at
 * @property string $end_at
 * @property string $body
 * @property boolean $rating
 * @property boolean $has_extra_file
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereHasExtraFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserJoinProject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserJoinProject extends Model
{
    protected $table = 'user_join_project';
}
