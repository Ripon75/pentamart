<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->boolean('ac_status')->default(false);
            $table->string('otp_code', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('terms_conditons')->default(false);
            $table->string('google_id', 1000)->nullable();
            $table->string('google_token', 1000)->nullable();
            $table->string('google_refresh_token', 1000)->nullable();
            $table->string('facebook_id', 1000)->nullable();
            $table->string('facebook_token', 1000)->nullable();
            $table->string('facebook_refresh_token', 1000)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
