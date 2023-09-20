<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferThemesTable extends Migration
{
    public function up()
    {
        Schema::create('offer_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offer_themes');
    }
}
