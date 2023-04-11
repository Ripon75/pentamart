<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('products', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 190);
            $table->foreignId('brand_id')->nullable()->constrained('brands')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by_id')->nullable()->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('offer_price', 20, 2)->default(0);
            $table->decimal('offer_percent', 20, 2)->default(0);
            $table->bigInteger('current_stock')->default(0);
            $table->enum('status', $status)->default('active');
            $table->string('image_src', 1000)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
