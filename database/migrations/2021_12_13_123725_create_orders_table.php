<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pg_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade')->comment('Payment gateway id');
            $table->foreignId('status_id')->nullable()->constrained('statuses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('address_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade')->comment('Shipping address id');
            $table->text('address')->nullable()->comment('Shipping address');
            $table->foreignId('coupon_id')->nullable()->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->decimal('coupon_value', 20, 2)->default(0);
            $table->decimal('delivery_charge', 20, 2)->default(0);
            $table->decimal('buy_price', 20, 2)->default(0);
            $table->decimal('mrp', 20, 2)->default(0);
            $table->decimal('sell_price', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('net_price', 20, 2)->default(0);
            $table->decimal('payable_price', 20, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->string('note', 1024)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
