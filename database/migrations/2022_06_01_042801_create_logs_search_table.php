<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_search', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('keywords', 100);
            $table->integer('result_count')->default(0);
            $table->foreignId('user_id')->nullable();
            $table->string('device_name', 200)->nullable();
            $table->string('platform', 200)->nullable();
            $table->string('platform_version', 200)->nullable();
            $table->string('browser', 200)->nullable();
            $table->string('browser_version', 200)->nullable();
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_phone')->default(false);
            $table->boolean('is_robot')->default(false);
            $table->string('robot_name', 200)->default(false);
            $table->ipAddress('ip')->default(false);
            $table->string('user_agent', 2000)->nullable();
            $table->json('ug_language')->nullable();
            $table->timestamp('logged_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_search');
    }
}
