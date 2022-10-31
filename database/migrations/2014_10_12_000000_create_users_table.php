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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->onDelete('cascade')->nullable();

            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email')->unique()->nullable();;
            $table->string('phone')->unique();
            $table->enum('role',['user','manager','admin','super'])->default('user');
            $table->string('password');
            $table->string('designation');
            $table->string('block')->default(0);
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
};
