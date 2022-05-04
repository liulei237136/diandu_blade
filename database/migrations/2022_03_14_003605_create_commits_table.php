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
        Schema::create('commits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->default('');
            $table->unsignedBigInteger('creator_id')->index();
            $table->unsignedBigInteger('owner_id')->index();
            $table->unsignedBigInteger('repository_id')->index();
            $table->string('file_path')->default('');
            $table->timestamps();

            // $table->foreign('creator_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('repository_id')->references('id')->on('repositories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commits');
    }
};
