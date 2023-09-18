<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use App\Models\AdvertiserProduct;
use App\Models\LinkClick;

class DBTest extends TestCase
{
    use RefreshDatabase;

    public function testAddData()
    {
        system('clear');
        echo "testAddData\n";
        $this->seed();

        echo "Пользователи:\n";
        foreach (User::all() as $user) {
            echo "  имя:{$user->name} почта:{$user->email} роль:{$user->role->name}\n";
        }

        echo "\nОфферы:\n";
        foreach (Offer::all() as $offer) {
            echo "  имя:{$offer->name}, тема:{$offer->theme->name}, описание:{$offer->description}, URL:{$offer->URL}\n";
        }

        echo "\nТовары рекламодателей:\n";
        foreach (AdvertiserProduct::all() as $product) {
            $status = $product->status === 1 ? 'вкл' : 'выкл';
            echo "  статус:$status, продавец:{$product->advertiser->name}, оффер:{$product->offer->name}";
            echo ", цена:{$product->price}";
            echo ", клики:{$product->links->count()}\n";
        }
        $this->assertDatabaseCount('users', 3);
    }
}
