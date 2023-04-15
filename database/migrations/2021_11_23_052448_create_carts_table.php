<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('delivery_type_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('shipping_address_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('note', 1024)->nullable();
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
        Schema::dropIfExists('carts');
    }
}
