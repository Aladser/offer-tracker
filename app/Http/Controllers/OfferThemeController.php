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
        if (OfferTheme::hasTheme($name)) {
            return ['result' => 'тема уже существует'];
        } else {
            return OfferTheme::add($name);
        }
    }

    public function destroy($id)
    {
        return json_encode(['result' => OfferTheme::destroy($id)]);
    }
}
