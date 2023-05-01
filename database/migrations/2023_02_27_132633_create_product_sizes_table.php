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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('size_id')->constrained('sizes')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();

            $table->primary(['product_id', 'size_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sizes');
    }
};
