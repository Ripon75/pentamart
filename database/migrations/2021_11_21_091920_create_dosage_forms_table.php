<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosageFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = config('enum.status');

        Schema::create('dosage_forms', function (Blueprint $table) use ($status){
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->enum('status', $status)->default('active');
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
        Schema::dropIfExists('dosage_forms');
    }
}
