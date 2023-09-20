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
        $this->assertDatabaseCount('offer_subscriptions', 9);
    }

    public function testFollowers()
    {
        echo "\nПодписчики:\n";
        foreach (Offer::all() as $offer) {
            echo "{$offer->name}. Подписчиков:{$offer->links->count()}\n";
        }
        $this->assertDatabaseCount('offer_subscriptions', 9);
    }

    public function testDoubleSubscriptions()
    {
        $subscription = new OfferSubscription();
        $subscription->follower_id = 1;
        $subscription->offer_id = 1;
        $subscription->save();
        $this->assertDatabaseHas('offer_subscriptions', ['follower_id' => 1, 'offer_id' => 1]);
    }
}

