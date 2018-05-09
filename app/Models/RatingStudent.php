<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RatingStudent
 *
 * @property integer $id
 * @property string $body
 * @property boolean $rating
 * @property integer $lecturer_id
 * @property integer $student_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereLecturerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $user_id
 * @property boolean $type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RatingStudent whereType($value)
 */
class RatingStudent extends Model
{
    protected $table = 'rating_student';
}
