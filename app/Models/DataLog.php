<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLog extends Model
{
    use HasFactory;

    protected $table = 'data_logs';

    protected $fillable = [
        'user_id',
        'type', // MOCHI/SILK
        'action', // PLUS/MINUS
        'points',
        'start', // only for TYPE = SILK
        'end', // only for TYPE = SILK
        'content'
    ];
}
