<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_banners', function (Blueprint $table) {
            $table->id();
            $table->string('bg_color')->nullable();
            $table->string('pre_title')->nullable();
            $table->string('title')->nullable();
            $table->string('post_title')->nullable();
            $table->string('img_src')->nullable();
            $table->string('status')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('medical_banners');
    }
}
