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
        $status = config('enum.status');

        Schema::create('sliders', function (Blueprint $table) use ($status) {
            $table->string('slug', 100);
            $table->string('name', 100);
            $table->enum('status', $status)->default('active');
            $table->string('large_src', 2048)->nullable();
            $table->string('small_src', 2048)->nullable();
            $table->boolean('is_top')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};
