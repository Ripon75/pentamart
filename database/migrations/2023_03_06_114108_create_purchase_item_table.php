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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchased_id');
            $table->foreignId('item_id');
            $table->decimal('mrp', 20, 2);
            $table->decimal('selling_price', 20, 2);
            $table->decimal('purchased_price', 20, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->index(['purchased_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_item');
    }
};
