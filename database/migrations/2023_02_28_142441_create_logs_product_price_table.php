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
        Schema::create('logs_product_price', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('old_mrp', 20, 2)->nullable();
            $table->decimal('new_mrp', 20, 2)->nullable();
            $table->decimal('old_selling_price', 20, 2)->nullable();
            $table->decimal('new_selling_price', 20, 2)->nullable();
            $table->timestamp('logged_at');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_product_price');
    }
};
