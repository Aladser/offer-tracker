<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\User;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferSubscription;

class DBTest extends TestCase
{
    use RefreshDatabase;
    
    public function testUsers()
    {
        system('clear');
        $this->seed();

        echo "Пользователи:\n";
        foreach (User::all() as $user) {
            echo "  имя:{$user->name} почта:{$user->email} роль:{$user->role->name}\n";
        }
        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseHas('user_roles', ['name' => 'рекламодатель', 'name' => 'веб-мастер', 'name' => 'администратор']);
    }

    public function testOfferThemes()
    {
        $this->assertDatabaseHas('offer_themes', ['name' => 'природа', 'name' => 'образование', 'name' => 'спорт']);
    }

    public function testOffers()
    {
        echo "\nСписок офферов:\n ".User::find(1)->name."\n";
        foreach (User::find(1)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }
        echo ' '.User::find(2)->name."\n";
        foreach (User::find(2)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }
        echo ' '.User::find(3)->name."\n";
        foreach (User::find(3)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }
        $this->assertDatabaseCount('offers', 9);
    }

    public function testOfferClicks()
    {
        echo "\nКлики офферов\n";
        foreach (OfferSubscription::all() as $click) {
            echo "  {$click->follower->name} подписался {$click->created_at} на {$click->product->name}\n";
        }
        $this->assertDatabaseCount('offer_subscriptions', 11);
    }

    public function testFollowers()
    {
        echo "\nПодписчики:\n";
        foreach (Offer::all() as $offer) {
            echo "{$offer->name}. Подписчиков:{$offer->links->count()}\n";
        }
        $this->assertDatabaseCount('offer_subscriptions', 11);
    }

    public function testDoubleSubscriptions()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        $subscription = new OfferSubscription();
        $subscription->follower_id = 1;
        $subscription->offer_id = 3;
        $subscription->save();
        $this->assertDatabaseCount('offer_subscriptions', 11);
    }

    public function testGetUserOffers() {
        if (User::all()->count() === 0) {
            $this->seed();
        }
        echo "Все подписки офферов:\n";
        $offers = User::find(2)->offers->all(); 
        foreach ($offers as $product) {
            foreach ($product->links as $link) {
                echo "имя:{$link->product->name} создан:{$link->created_at} цена:{$link->product->price}\n";
            }
        }

        echo "\nДата: 2023-09-22 22:44:42\n";

        $table = DB::table('offer_subscriptions')
        ->join('offers', function($join) {
            $date = new \DateTime("2023-09-22 22:44:42");
            $date->modify('-1 day');
            $lastDayDate = $date->format('Y-m-d H:i:s');
            echo "Прошлый день: $lastDayDate. Сумма = ";
            $join->on('offers.id', '=', 'offer_subscriptions.offer_id')->where('advertiser_id', '=', '2')->where('created_at', '>', $lastDayDate);
        });
        echo $table->get()->sum('price') . "р. Подписчиков:" . $table->get()->count() . "\n";

        $table = DB::table('offer_subscriptions')
        ->join('offers', function($join) {
            $date = new \DateTime("2023-09-22 22:44:42");
            $date->modify('-1 month');
            $lastMonthDate = $date->format('Y-m-d H:i:s');
            echo "Прошлый месяц: $lastMonthDate. Сумма = ";
            $join->on('offers.id', '=', 'offer_subscriptions.offer_id')->where('advertiser_id', '=', '2')->where('created_at', '>', $lastMonthDate);
        });
        echo $table->get()->sum('price') . "р. Подписчиков:" . $table->get()->count() . "\n";

        $table = DB::table('offer_subscriptions')
        ->join('offers', function($join) {
            $date = new \DateTime("2023-09-22 22:44:42");
            $date->modify('-1 year');
            $lastYearDate = $date->format('Y-m-d H:i:s');
            echo "Прошлый год: $lastYearDate. Сумма = ";
            $join->on('offers.id', '=', 'offer_subscriptions.offer_id')->where('advertiser_id', '=', '2')->where('created_at', '>', $lastYearDate);
        });
        echo $table->get()->sum('price') . "р. Подписчиков:" . $table->get()->count() . "\n";
        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}

