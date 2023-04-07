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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchased_by_id');
            $table->foreignId('order_id');
            $table->foreignId('pharmacy_id')->nullable();
            $table->string('pharmacy_name')->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->foreignId('note')->nullable();
            $table->timestamps();

            $table->index(['purchased_by_id', 'order_id', 'pharmacy_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
