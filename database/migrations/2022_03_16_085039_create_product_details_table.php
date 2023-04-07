<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->text('indication')->nullable();
            $table->text('description')->nullable();
            $table->text('pharmacology')->nullable();
            $table->text('dosage')->nullable();
            $table->text('administration')->nullable();
            $table->text('interaction')->nullable();
            $table->text('contraindication')->nullable();
            $table->text('side_effect')->nullable();
            $table->text('pregnancy')->nullable();
            $table->text('warning')->nullable();
            $table->text('uses')->nullable();
            $table->text('therapeutic')->nullable();
            $table->text('storage_condition')->nullable();
            $table->text('disclaimer')->nullable();
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
        Schema::dropIfExists('product_details');
    }
}
