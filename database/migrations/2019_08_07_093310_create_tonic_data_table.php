<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTonicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tonic_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->Integer('hour_of_day')->nullable();
            $table->Integer('view')->default(0);
            $table->Integer('term_view')->default(0);
            $table->Integer('ad_click')->default(0);
            $table->Integer('clicks')->default(0);
            $table->Integer('revenue_usd')->nullable();
            $table->string('subid1')->nullable();
            $table->string('subid2')->nullable();
            $table->string('subid3')->nullable();
            $table->string('subid4')->nullable();
            $table->string('campaign')->nullable();
            $table->string('country')->nullable();
            $table->string('keyword')->nullable();
            $table->Integer('day_of_week')->nullable();
            $table->string('affiliate_network')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tonic_data');
    }
}
