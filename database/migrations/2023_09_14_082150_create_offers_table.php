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
            $table->string('name')->nullable(false)->unique();
            $table->string('description')->nullable();
            $table->string('URL')->nullable(false)->unique();

            $table->bigInteger('theme_id')->unsigned();
            $table->foreign('theme_id')->references('id')->on('offer_themes')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
