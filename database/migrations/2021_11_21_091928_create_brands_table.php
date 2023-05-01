<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('brands', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('slug', 100);
            $table->string('name', 100);
            $table->enum('status', $status)->default('active');
            $table->string('img_src', 2048)->nullable();
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
        Schema::dropIfExists('brands');
    }
}
