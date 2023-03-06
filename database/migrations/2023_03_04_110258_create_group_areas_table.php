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
        Schema::create('group_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('division_id')->index();
            $table->string('status')->nullable();
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();

//            $table->foreign('group_id')
//                ->references('id')
//                ->on('groups');
//
//            $table->foreign('division_id')
//                ->references('id')
//                ->on('divisions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_areas');
    }
};
