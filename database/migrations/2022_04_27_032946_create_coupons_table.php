<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('status')->default('activated');
            $table->string('discount_type')->default('fixed');
            $table->decimal('discount_amount', 20, 2)->nullable();
            $table->decimal('min_cart_amount', 20, 2)
                  ->comment('The coupon code will be applied if cart minimum amount is this value');
            $table->string('applicable_on')->nullable()->comment('Ex: Cart, Product, Delivery fee');
            $table->string('description')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
