<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use App\Models\OfferTheme;
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

        echo "Роли пользователей: ";
        foreach (UserRole::all()->toArray() as $role) {
            echo "{$role['name']}, ";
        }
        echo "\nПользователи: ";
        foreach (User::all()->toArray() as $user) {
            echo "->{$user['name']} {$user['email']} {$user['role_id']}<- ";
        }
        echo "\nТемы офферов: ";
        foreach (OfferTheme::all()->toArray() as $offerTheme) {
            echo "{$offerTheme['name']}, ";
        }
        echo "\nОфферы: ";
        foreach (Offer::all()->toArray() as $offer) {
            echo "->{$offer['name']}, {$offer['theme_id']}, {$offer['URL']}<- ";
        }
        echo "\nСсылки рекламодателей: ";
        foreach (AdvertiserProduct::all()->toArray() as $product) {
            echo "->{$product['status']}, {$product['advertiser_id']}, {$product['offer_id']}, {$product['price']}, {$product['clicks']}<- ";
        }
        echo "\nКлики ссылок: ";
        foreach (LinkClick::all()->toArray() as $click) {
            echo "->{$click['advertiser_product_id']} {$click['created_at']}<- ";
        }

        $this->assertDatabaseCount('users', 1);
    }
}
