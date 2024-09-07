<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    public $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'profile_id',
        'avatar',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'score',
        'point_silk',
        'point_mochi',
        'first_time',
        'is_lucky'
    ];

    protected $appends = [
        'fullname',
        'total_silk',
        'use_mochi',
        'time_duration',
        'quests',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'achievements' => 'json',
    ];
    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getGenderAttribute()
    {
        return $this->attributes['gender'] == 1 ? 'Nam' : 'Nữ';
    }
    public function getBirthdayAttribute()
    {
        return date('d-m-Y', strtotime($this->attributes['birthday']));
    }
    public function getTotalSilkAttribute()
    {
        return User::sum('point_silk');
    }
    public function getTimeDurationAttribute()
    {
        return EVENT_BIRTHDAY12['time'];
    }
    public function getUseMochiAttribute()
    {
        return EVENT_BIRTHDAY12['mochi'];
    }
    public function getQuestsAttribute()
    {
        return app(Helpers::class)->getUserQuests();
    }
    public function scoreLogs()
    {
        return $this->hasMany(ScoreLog::class, 'user_id');
    }
}