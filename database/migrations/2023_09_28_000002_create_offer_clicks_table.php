<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SystemOption;

class CreateOfferClicksTable extends Migration
{
    public function up()
    {
        Schema::create('offer_clicks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->float('income_part', 3, 2)->unsigned()->default(0.8);

            $table->bigInteger('webmaster_id')->unsigned();
            $table->foreign('webmaster_id')->references('id')->on('webmasters')->cascadeOnDelete();

            $table->bigInteger('offer_id')->unsigned();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offer_clicks');
    }
}
