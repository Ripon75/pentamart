<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->decimal('amount', 20, 2)->default(0);
            $table->string('type')->nullable();
            $table->foreignId('pg_id')->default(1);
            $table->string('payment_id')->nullable()
                ->comment('This data will come from the gateway api.');
            $table->string('pg_trxid')->nullable()
                ->comment('This data will come from the gateway api.');
            $table->string('status')->default('submitted');
            $table->string('remark', 1000)->nullable();
            $table->foreignId('trx_by_id')->nullable();
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
        Schema::dropIfExists('payment_transactions');
    }
}
