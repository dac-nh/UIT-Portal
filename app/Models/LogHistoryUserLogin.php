<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Log\LogHistoryUserLogin
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LogHistoryUserLogin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LogHistoryUserLogin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LogHistoryUserLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LogHistoryUserLogin whereUpdatedAt($value)
 */
class LogHistoryUserLogin extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'log_history_user_login';
    //
}
