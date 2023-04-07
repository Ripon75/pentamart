<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('pre_title')->nullable();
            $table->string('pre_title_link')->nullable();
            $table->string('title')->nullable();
            $table->string('title_link')->nullable();
            $table->string('post_title')->nullable();
            $table->string('post_title_link')->nullable();
            $table->string('box_link')->nullable();
            $table->string('position')->nullable();
            $table->string('serial')->nullable();
            $table->string('img_src')->nullable();
            $table->string('status')->nullable();
            $table->string('caption')->nullable();
            $table->string('bg_color')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
