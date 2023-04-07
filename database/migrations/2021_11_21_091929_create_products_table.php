<?php

use Illuminate\Support\Facades\DB;
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

        // DB::statement('ALTER TABLE products ADD FULLTEXT fulltext_index (name, meta_keywords, meta_description)');
        // Product attribute table
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 190)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('input_type', 100)->nullable();
            $table->string('attribute_group', 100)->nullable();
            $table->boolean('required')->default(true);
            $table->boolean('visible_on_front')->default(true);
            $table->boolean('comparable')->default(false);
            $table->boolean('filterable')->default(false);
            $table->boolean('user_defined')->default(true);
            $table->string('value_cast')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Product attribute family
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 190)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('user_defined')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Product category table
        Schema::create('categories', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('slug', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->enum('status', $status)->default('draft');
            $table->string('color', 6)->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('family_id')->nullable();
            $table->string('description', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Product & Product category (relation table)
        Schema::create('product_category', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('category_id');
            $table->timestamps();
        });

        // Product attribute & product attribut family category (relation table)
        Schema::create('family_attribute', function (Blueprint $table) {
            $table->foreignId('family_id');
            $table->foreignId('attribute_id');
            $table->string('attribute_group')->nullable();
            $table->timestamps();
        });

        // Product attribute options
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id');
            $table->string('value', 190);
            $table->string('label', 255);
            $table->timestamps();
        });

        // Product & product attribute (relation table)
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('attribute_id');
            $table->string('value')->nullable();
            $table->timestamps();
        });

        // Product category & filter attribute
        Schema::create('category_attribute', function (Blueprint $table) {
            $table->foreignId('category_id');
            $table->foreignId('attribute_id');
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('families');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('product_category');
        Schema::dropIfExists('family_attribute');
        Schema::dropIfExists('attribute_options');
        Schema::dropIfExists('attribute_value');
        Schema::dropIfExists('category_attribute_filterable');
    }
}
