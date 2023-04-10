<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('products', function (Blueprint $table) use ($status) {
            $table->id();
            // TODO: add unique
            $table->string('slug', 190);
            // TODO: add unique
            $table->string('name', 200);
            $table->foreignId('dosage_form_id')->nullable()->constrained('dosage_forms')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('generic_id')->nullable()->constrained('generics')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('companies')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('pos_product_id')->nullable();
            $table->decimal('mrp', 20, 2)->default(0);
            $table->decimal('selling_price', 20, 2)->default(0);
            $table->decimal('selling_percent', 20, 2)->default(0);
            $table->enum('status', $status)->default('draft');
            $table->text('description')->nullable();
            $table->string('image_src', 1000)->nullable();
            $table->string('meta_title', 1000)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('counter_type')->default('none')->comment('Is over the counter medicine');
            $table->integer('pack_size')->nullable();
            $table->string('pack_name', 100)->nullable();
            $table->integer('num_of_pack')->nullable();
            $table->string('uom')->nullable();
            $table->boolean('is_single_sell_allow')->default(false);
            $table->boolean('is_refrigerated')->default(false);
            $table->boolean('is_express_delivery')->default(false);
            $table->foreignId('created_by_id')->nullable()->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
