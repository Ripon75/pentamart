<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('categories', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name', 100)->unique();
            $table->enum('status', $status)->default('draft');
            $table->string('color', 6)->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->string('description', 1000)->nullable();
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
        Schema::dropIfExists('categories');
    }
}
