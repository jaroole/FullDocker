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

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id()->from(1);
            $table->timestamps();
            
            
            $table->string('Направление')->nullable();
            $table->string('team')->nullable();
            $table->string('name')->nullable();
            $table->string('Почта')->nullable();
            $table->string('telegram')->unique();
            $table->string('Тип')->nullable();
            $table->string('jobTitle')->nullable();
            $table->string('grade')->nullable();
            $table->string('ПИР')->nullable();           

            $table->string('question')->nullable();
            $table->string('answer')->nullable();
            $table->string('answerDate')->nullable();

            $table->boolean('registered')->default(false);
            $table->boolean('active')->default(false);



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


