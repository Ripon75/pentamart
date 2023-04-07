<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->boolean('seller_visibility')->default(false);
            $table->boolean('customer_visibility')->default(false);
            $table->string('description', 1000)->nullable();
            $table->string('bg_color', 50)->default('#fff');
            $table->string('text_color', 50)->default('#000');
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
        Schema::dropIfExists('order_statuses');
    }
}
