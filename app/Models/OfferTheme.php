<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTheme extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function offers()
    {
        return $this->hasMany(Offer::class, 'theme_id', 'id');
    }

    public static function add($name)
    {
        $theme = new OfferTheme();
        $theme->name = $name;
        return ['result' => $theme->save() ? 1 : 0, 'row' => $theme->toArray()];
    }

    public static function destroy($id)
    {
        return OfferTheme::find($id)->delete() ? 1 : 0;
    }

    public static function hasTheme($name)
    {
        return !is_null(OfferTheme::where('name', $name)->first());
    }
}
