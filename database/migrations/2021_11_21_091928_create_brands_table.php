<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('brands', function (Blueprint $table) use ($status) {
            $table->id();
            // TODO : add unique
            $table->string('slug', 100);
            // TODO : add unique
            $table->string('name', 100);
            $table->enum('status', $status)->default('draft');
            $table->string('logo_path', 2048)->nullable();
            $table->foreignId('company_id')->nullable()->constrained('companies')
                  ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('brands');
    }
}
