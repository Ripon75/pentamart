<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_map', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained('orders')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('order_statuses')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_map');
    }
}
