<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedOfferClicksTable extends Migration
{
    public function up()
    {
        Schema::create('failed_offer_clicks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->string('url')->nullable(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('failed_offer_clicks');
    }
}
