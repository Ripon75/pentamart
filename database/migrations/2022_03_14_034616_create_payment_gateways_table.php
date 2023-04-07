<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('payment_gateways', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name', 100)->unique();
            $table->string('code', 10)->unique()->nullable();
            $table->enum('status', $status)->default('draft');
            $table->string('img_src', 100)->nullable();
            $table->string('icon', 100)->nullable();
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
        Schema::dropIfExists('payment_gateways');
    }
}
