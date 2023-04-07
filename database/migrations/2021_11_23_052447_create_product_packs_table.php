<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_packs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('uom_id')->nullable()->constrained('uoms')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->integer('piece')->nullable();
            $table->decimal('price', 30, 8)->default(0);
            $table->integer('min_order_qty')->nullable();
            $table->integer('max_order_qty')->nullable();
            $table->string('description', 500)->nullable();
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
        Schema::dropIfExists('product_packs');
    }
}
