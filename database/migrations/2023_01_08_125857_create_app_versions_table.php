<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->comment("android, ios");
            $table->integer('version_code');
            $table->string('version_name');
            $table->integer('status')->default("1")->comment("1 = active, 2 = deprecated, 3 = deactivated");
            $table->text('description')->nullable();
            $table->dateTime("release_date")->useCurrent();
            $table->date("deprecated_date")->nullable();
            $table->date("deactivated_date")->nullable();
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
        Schema::dropIfExists('app_versions');
    }
};
