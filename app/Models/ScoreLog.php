<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreLog extends Model
{
    use HasFactory;

    protected $table = 'score_logs';

    protected $fillable = [
        'user_id',
        'scores',
        'start',
        'end'
    ];
}