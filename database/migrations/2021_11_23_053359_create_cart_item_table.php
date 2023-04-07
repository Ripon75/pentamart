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
            $table->foreignId('cart_id')->nullable()->constrained('carts')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->nullable()->constrained('products')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->integer('item_pack_size')->nullable();
            $table->decimal('item_mrp', 20, 2)->default(0);
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
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
