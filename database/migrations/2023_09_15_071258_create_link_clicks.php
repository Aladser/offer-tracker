<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkClicks extends Migration
{
    public function up()
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('advertiser_product_id')->unsigned();
            $table->foreign('advertiser_product_id')->references('id')->on('advertiser_products');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('link_clicks');
    }
}
