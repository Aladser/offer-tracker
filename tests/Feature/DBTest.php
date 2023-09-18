<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Offer;
use App\Models\AdvertiserProduct;
use App\Models\OfferSubscription;

class DBTest extends TestCase
{
    use RefreshDatabase;

    public function testAddData()
    {
        system('clear');
        $this->seed();
        $this->assertDatabaseCount('users', 3);
    }

    public function testGetData()
    {
        echo "Пользователи:\n";
        foreach (User::all() as $user) {
            echo "  имя:{$user->name} почта:{$user->email} роль:{$user->role->name}\n";
        }

        echo "\nТовары рекламодателей:\n";
        foreach (AdvertiserProduct::all() as $product) {
            $status = $product->status === 1 ? 'вкл' : 'выкл';
            echo "  статус:$status, продавец:{$product->advertiser->name}, оффер:{$product->offer->name}";
            echo ", цена:{$product->price}";
            echo ", клики:{$product->links->count()}\n";
        }

        echo "\nКлики офферов\n";
        foreach (OfferSubscription::all() as $click) {
            echo "  {$click->follower->name} подписался {$click->created_at} на {$click->product->offer->name}\n";
        }
        $this->assertDatabaseCount('users', 3);
    }

    public function testGetOffers()
    {
        echo "\nСписок офферов ".User::find(1)->name."\n";
        foreach (User::find(1)->advertiser_products->all() as $product) {
            $status = $product->status ? 'вкл' : 'выкл'; 
            echo "  $status {$product->price} {$product->offer->name}\n";
        }
        $this->assertDatabaseCount('advertiser_products', 7);
    }

    public function testGetFollowers()
    {
        echo "\nПодписчики = " . AdvertiserProduct::find(1)->links->count() . ". ";

        foreach (AdvertiserProduct::find(1)->links as $follower) {
            echo "{$follower->follower->name}, ";
        }
        $this->assertDatabaseCount('advertiser_products', 7);
    }
}

