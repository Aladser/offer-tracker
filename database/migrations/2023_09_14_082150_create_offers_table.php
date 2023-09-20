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
            $table->string('url')->nullable(false)->unique();
            $table->string('name')->unique();

            $table->boolean('status')->default(false);
            $table->integer('price')->unsigned()->default(0);

            $table->bigInteger('theme_id')->unsigned();
            $table->foreign('theme_id')->references('id')->on('offer_themes')->cascadeOnDelete();

            $table->bigInteger('advertiser_id')->unsigned();
            $table->foreign('advertiser_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('url');
    }
}
