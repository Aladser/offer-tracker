<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->bigInteger('follower_id')->unsigned();
            $table->foreign('follower_id')->references('id')->on('users')->cascadeOnDelete();

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();

            $table->index(['follower_id', 'offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_subscriptions');
    }
}
