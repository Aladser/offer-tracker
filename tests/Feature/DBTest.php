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
        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseHas('user_roles', ['name' => 'рекламодатель', 'name' => 'веб-мастер', 'name' => 'администратор']);
    }

    public function testOfferThemes()
    {
        $this->assertDatabaseHas('offer_themes', ['name' => 'природа', 'name' => 'образование', 'name' => 'спорт']);
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
        echo "\nОфферы и число подписчиков:\n";
        foreach (Offer::all() as $offer) {
            echo "  {$offer->name}. Подписчиков:{$offer->links->count()}\n";
        }
        echo "\n";
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

    public function testOffers()
    {
        echo "Список офферов:\n ".User::find(1)->name."\n";
        foreach (User::find(1)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "  url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }

        echo ' '.User::find(2)->name."\n";
        foreach (User::find(2)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "  url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }

        echo ' '.User::find(3)->name."\n";
        foreach (User::find(3)->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "  url:{$offer->url} имя:{$offer->name} статус:$status цена:{$offer->price}\n";
        }

        echo "\nВсе подписки офферов ".User::find(2)->name.":\n";
        $offers = User::find(2)->offers->all(); 
        foreach ($offers as $product) {
            foreach ($product->links as $link) {
                echo "  имя:{$link->product->name} создан:{$link->created_at} цена:{$link->product->price}\n";
            }
        }

        $this->assertDatabaseCount('offers', 9);
    }

    public function testGetUserOffers() {
        if (User::all()->count() === 0) {
            $this->seed();
        }

        $advertiser_id = 2;
        $offers = User::find(2)->offers; 

        // офферы за все время
        echo 'Офферы рекламщика ' . User::find($advertiser_id)->name . "\n" . StatisticController::getDate() . ":\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->count()} Доход:"
                . $offer->links->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->get()->count()}. Сумма: {$data->get()->sum('price')}\n\n";

        // офферы за последний день
        $lastDate = StatisticController::getDate('-1 day');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        // офферы за последний месяц
        $lastDate = StatisticController::getDate('-1 month');
        echo "$lastDate\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        // офферы за последний год
        $lastDate = StatisticController::getDate('-1 year');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
