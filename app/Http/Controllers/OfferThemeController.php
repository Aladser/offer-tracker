<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferTheme;

class OfferThemeController extends Controller
{
    public function index(Request $request)
    {
        return view('pages/offer-theme', ['themes' => OfferTheme::all()->toArray()]);
    }

    public function store(Request $request)
    {
        $name = $request->all()['name']; 
        $isTheme = !is_null(OfferTheme::where('name', $name)->first());
        if ($isTheme) {
            return ['result' => 'тема уже существует'];
        } else {
            $theme = new OfferTheme();
            $theme->name = $name;
            return ['result' => $theme->save() ? 1 : 0, 'row' => $theme->toArray()];
        }
    }

    public function destroy($id)
    {
        return ['result' => OfferTheme::find($id)->delete() ? 1 : 0];
    }
}
