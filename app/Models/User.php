<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// пользователь
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    public $timestamps = false; // без времени создания

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // роль
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    // рекламодатель
    public function advertiser()
    {
        return $this->hasOne(Advertiser::class);
    }

    // подписчик
    public function webmaster()
    {
        return $this->hasOne(Webmaster::class);
    }
}
