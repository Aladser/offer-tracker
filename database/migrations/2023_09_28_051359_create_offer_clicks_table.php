<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferClicksTable extends Migration
{
    public function up()
    {
        Schema::create('offer_clicks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offer_clicks');
    }
}
