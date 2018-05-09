<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skill
 *
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Skill whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Skill whereName($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Skill whereUpdatedAt($value)
 */
class Skill extends Model
{
    protected $table = 'skill';
}
