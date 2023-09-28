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
use App\Http\Controllers\StatisticController;

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
        $this->assertDatabaseHas('user_roles', ['name' => 'рекламодатель', 'name' => 'веб-мастер', 'name' => 'администратор']);
    }

    public function testOfferClicks()
    {
        echo "\nКлики офферов\n";
        foreach (OfferSubscription::all() as $click) {
            echo "  {$click->follower->name} подписался {$click->created_at} на {$click->offer->name}\n";
        }
        $this->assertDatabaseCount('offer_subscriptions', 10);
    }

    public function testFollowers()
    {
        echo "\nОфферы и число подписчиков:\n";
        foreach (Offer::all() as $offer) {
            echo "  {$offer->name} создан {$offer->advertiser->user->name}. Подписчиков:{$offer->links->count()}\n";
        }
        echo "\n";
        $this->assertDatabaseCount('offer_subscriptions', 10);
    }

    public function testDoubleSubscriptions()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        $subscription = new OfferSubscription();
        $subscription->follower_id = 1;
        $subscription->offer_id = 3;
        $subscription->save();
        $this->assertDatabaseCount('offer_subscriptions', 10);
    }

    private function getOffers($user)
    {
        echo "Список офферов:\n ".$user->name."\n";
        foreach ($user->advertiser->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "  url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }
    }

    public function testOffers()
    {
        $this::getOffers(User::find(1));
        $this::getOffers(User::find(2));
        $this::getOffers(User::find(3));
        $this->assertDatabaseCount('offers', 9);
    }
}
