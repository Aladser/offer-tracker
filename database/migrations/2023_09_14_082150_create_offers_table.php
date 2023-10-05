<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('url')->nullable(false)->default('https://laravel.su/docs/8.x');

            $table->integer('price')->unsigned()->default(0);

            $table->bigInteger('theme_id')->unsigned();
            $table->foreign('theme_id')->references('id')->on('offer_themes')->cascadeOnDelete();

            $table->bigInteger('advertiser_id')->unsigned();
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->cascadeOnDelete();

            $table->boolean('status')->default(true);
            $table->unique(['name', 'advertiser_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
