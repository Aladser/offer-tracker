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
            $table->bigInteger('theme')->unsigned();
            $table->foreign('theme')->references('id')->on('offer_themes');
            $table->string('URL')->nullable(false)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
