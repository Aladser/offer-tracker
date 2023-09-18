<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('offer_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->bigInteger('follower_id')->unsigned();
            $table->foreign('follower_id')->references('id')->on('users');

            $table->bigInteger('advertiser_product_id')->unsigned();
            $table->foreign('advertiser_product_id')->references('id')->on('advertiser_products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offer_subscriptions');
    }
}
