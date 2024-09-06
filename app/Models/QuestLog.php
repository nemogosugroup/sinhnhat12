<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestLog extends Model
{
    use HasFactory;

    protected $table = 'quest_logs';

    protected $fillable = [
        'user_id',
        'quest_id', // get in QUEST define
        'date_number', // 1,2,3,4
        'code',
        'is_done',
        'is_received'
    ];
}
