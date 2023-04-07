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
            $table->foreignId('pos_business_id')->nullable();
            $table->foreignId('pos_branch_id')->nullable();
            $table->foreignId('delivery_type_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('shipping_address_id')->nullable()->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->decimal('coupon_value', 20, 2)->default(0)->nullable();
            $table->foreignId('current_status_id')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->decimal('refund_amount', 20, 2)->default(0)->nullable();
            $table->decimal('delivery_charge', 20, 2)->nullable();
            $table->decimal('total_special_discount', 20, 2)->default(0)->nullable();
            $table->decimal('total_items_discount', 20, 2)->default(0)->nullable();
            $table->decimal('order_items_value', 20, 2)->default(0)->nullable()->comment('Sum of total items price');
            $table->decimal('order_items_mrp', 20, 2)->default(0)->nullable()->comment('Sum of total items mrp');
            $table->decimal('payable_order_value', 20, 2)->default(0)->nullable()->comment('Order payable amount');
            $table->string('refund_status')->nullable();
            $table->timestamp('refund_date')->nullable();
            $table->string('note', 1024)->nullable();
            $table->string('ref_code', 1024)->nullable();
            $table->integer('ratings')->nullable();
            $table->timestamp('current_status_at')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('sell_partner_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
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
