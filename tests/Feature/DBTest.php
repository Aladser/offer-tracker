<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Http\Controllers\StatisticController;

class DBTest extends TestCase
{
    use RefreshDatabase;
    
    public function testFollowers()
    {
        system('clear');
        $this->seed();

        echo "\nОфферы и число подписчиков:\n";
        foreach (Offer::all() as $offer) {
            echo "  {$offer->name} создан {$offer->advertiser->user->name}. Подписчиков:{$offer->links->count()}\n";
        }
        echo "\n";
        
        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testDoubleSubscriptions()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        $subscription = new OfferSubscription();
        $subscription->follower_id = 1;
        $subscription->offer_id = 3;
        $subscription->save();

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testOffers()
    {
        echo "Список офферов\n";
        $this::getOffers(1);
        $this::getOffers(2);
        $this::getOffers(3);

        $this->assertDatabaseCount('offers', 8);
    }

    private function getOffers($id)
    {
        $this->seedTest();
        
        $advertiser = Advertiser::find($id);
        echo $advertiser->user->name . "\n";
        foreach ($advertiser->offers->all() as $offer) {
            $status = $offer->status ? 'вкл' : 'выкл'; 
            echo "  {$offer->name} url:{$offer->url} статус:$status цена:{$offer->price}\n";
        }
    }
}
