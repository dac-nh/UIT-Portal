<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cv
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereName($value)
 * @mixin \Eloquent
 * @property-read \App\Models\StudentProfile $studentprofiles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cv whereUpdatedAt($value)
 */
class Cv extends Model
{
    protected $table = 'cv';

    public function studentprofiles(){
        return $this->belongsTo('App\Models\StudentProfile','student_id');
    }
}
