<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telega_users', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->timestamps();

            $table->string('userId')->unique();
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->string('jibTitle')->nullable();
            $table->string('grade')->nullable();
            

            $table->string('avatar')->nullable();
            $table->boolean('active')->default(true);

            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telega_users');
    }
};


