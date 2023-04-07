<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUOMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $typeUOM = config('enum.typeUOM');

        Schema::create('uoms', function (Blueprint $table) use ($typeUOM) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name', 100)->unique();
            $table->string('code', 10)->unique();
            $table->enum('type', $typeUOM)->default('volume');
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
        Schema::dropIfExists('uoms');
    }
}
