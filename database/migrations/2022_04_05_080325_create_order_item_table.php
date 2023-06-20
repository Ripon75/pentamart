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
        Schema::create('order_item', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('item_id')->constrained('products')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
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
        Schema::dropIfExists('order_item');
    }
}
