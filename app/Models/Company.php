<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $address_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $project
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $address
 * @property string $phone
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company wherePhone($value)
 * @property boolean $rating
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereRating($value)
 * @property string $avatar
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereAvatar($value)
 */
class Company extends Model
{
    protected $table = 'company';
    public function project(){
        return $this->hasMany('App\Models\Project');
    }
}
