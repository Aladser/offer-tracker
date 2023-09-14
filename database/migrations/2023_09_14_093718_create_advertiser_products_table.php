<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiserProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_products', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            
            $table->bigInteger('adertiser_id')->unsigned();
            $table->foreign('adertiser_id')->references('id')->on('users');

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers');

            $table->integer('price')->unsigned();
            $table->integer('clickes')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertiser_products');
    }
}
