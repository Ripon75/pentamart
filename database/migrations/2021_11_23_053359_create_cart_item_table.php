<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->foreignId('cart_id')->constrained('carts')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('products')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('item_buy_price', 20, 2)->default(0);
            $table->decimal('item_mrp', 20, 2)->default(0);
            $table->decimal('item_sell_price', 20, 2)->default(0);
            $table->decimal('item_discount', 20, 2)->default(0);
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
        Schema::dropIfExists('cart_item');
    }
}
