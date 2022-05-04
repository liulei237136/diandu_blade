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
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('star_count')->default(0);
            $table->unsignedInteger('comment_count')->default(0);
            $table->unsignedInteger('clone_count')->default(0);
            // $table->integer('last_reply_user_id')->unsigned()->default(0);
            // $table->integer('order')->unsigned()->default(0);
            $table->text('excerpt')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
};
