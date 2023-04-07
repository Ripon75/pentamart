<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('delivery_gateways', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name', 100)->unique();
            $table->string('code', 10)->unique();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('min_delivery_time')->nullable();
            $table->integer('max_delivery_time')->nullable();
            $table->string('delivery_time_unit')->nullable();
            $table->enum('status', $status)->default('draft');
            $table->string('description', 1000)->nullable();
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
        Schema::dropIfExists('delivery_gateways');
    }
}
