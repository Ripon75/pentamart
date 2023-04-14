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
            $table->foreignId('address_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->decimal('coupon_value', 20, 2)->default(0)->nullable();
            $table->decimal('delivery_charge', 20, 2)->default(0);
            $table->decimal('order_price', 20, 2)->default(0);
            $table->decimal('order_sell_price', 20, 2)->default(0);
            $table->decimal('order_discount', 20, 2)->default(0);
            $table->decimal('order_payable_price', 20, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('current_status_id')->nullable()->constrained('statuses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('current_status_at')->nullable();
            $table->foreignId('created_by_id')->nullable();
            $table->string('note', 1024)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
