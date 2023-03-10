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
        // change the duration from the ms to '00:00'
        // run migration

        // maybe it woth to replace the 'id' field with 'spotify_id'?
        // ask Dron

        // add the 'track_number' field
        // 'pupularity' (later)
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('duration_ms');
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('album_id');
            $table->string('spotify_url');
            $table->string('isrc');
            $table->string('added_at');
            $table->string('spotify_id');
            $table->timestamps();
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
};
