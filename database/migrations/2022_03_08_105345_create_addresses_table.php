<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('phone_number', 20)->nullable();
            $table->string('phone_number_2', 20)->nullable();
            $table->foreignId('district_id')->nullable()->nullable();
            $table->string('thana')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
