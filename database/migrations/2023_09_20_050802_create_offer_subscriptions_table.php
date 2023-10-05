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
            $table->string('refcode')->unique()->nullable(false);

            $table->bigInteger('webmaster_id')->unsigned();
            $table->foreign('webmaster_id')->references('id')->on('webmasters')->cascadeOnDelete();

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();

            $table->unique(['webmaster_id', 'offer_id']);
            $table->index(['webmaster_id', 'offer_id', 'refcode']);
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
