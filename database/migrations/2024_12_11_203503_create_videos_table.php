<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->string('tag')->unique();
            $table->string('publisher');
            $table->foreign('publisher')->references('channel_name')->on('channels')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->string('description');
            $table->string('thumbnail');
            $table->string('video');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
