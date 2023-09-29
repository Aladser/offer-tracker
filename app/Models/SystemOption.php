<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemOption extends Model
{
    public $timestamps = false;

    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
