<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attraction_user_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('attraction_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')->on('tbl_user')
                ->onDelete('cascade');

            $table->foreign('attraction_id')
                ->references('attr_id')->on('tbl_attraction')
                ->onDelete('cascade');

            $table->unique(['user_id', 'attraction_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attraction_user_likes');
    }
};
