<?php

namespace App\Http\Controllers;

use App\Models\OfferTheme;
use Illuminate\Http\Request;

class OfferThemeController extends Controller
{
    public function index()
    {
        return view('pages/offer-theme', ['themes' => OfferTheme::all()->toArray()]);
    }

    public function store(Request $request): array
    {
        $name = $request->all()['name'];
        // поиск темы в БД
        if (OfferTheme::where('name', $name)->exists()) {
            return ['result' => 0, 'description' => 'тема уже существует'];
        } else {
            $theme = new OfferTheme();
            $theme->name = $name;
            $themeSaved = $theme->save();

            if ($themeSaved) {
                return ['result' => 1,
                        'row' => ['id' => $theme->id, 'name' => $theme->name],
                    ];
            } else {
                return ['result' => 0,
                        'description' => 'Серверная ошибка сохранения пользователя',
                    ];
            }
        }
    }

    public function destroy($id): array
    {
        return ['result' => OfferTheme::find($id)->delete() ? 1 : 0];
    }
}
