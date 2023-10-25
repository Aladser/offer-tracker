<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// роль пользователя
class UserRole extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // пользователи
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
