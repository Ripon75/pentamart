<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.okStatus');

        Schema::create('order_item', function (Blueprint $table) use ($status){
            $table->foreignId('order_id')->nullable()->constrained('orders')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->nullable()->constrained('products')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('pack_size')->nullable();
            $table->decimal('item_mrp', 20, 2)->nullable();
            $table->decimal('price', 20, 2)->nullable()
            ->commit('Price of the item when it`s added into the cart');
            $table->decimal('discount', 20, 2)->nullable();
            $table->foreignId('promotion_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->enum('status', $status)->default('ok');
            $table->foreignId('pos_product_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade')->commit('Medipos product id');
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
        Schema::dropIfExists('order_item');
    }
}
