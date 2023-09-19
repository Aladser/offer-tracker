<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiserProductsTable extends Migration
{
    public function up()
    {
        Schema::create('advertiser_products', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->integer('price')->unsigned();
            
            $table->bigInteger('advertiser_id')->unsigned();
            $table->foreign('advertiser_id')->references('id')->on('users')->cascadeOnDelete();

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertiser_products');
    }
}
