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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('release_date');
            $table->unsignedBigInteger('artist_id');
            $table->string('artist');
            $table->string('spotify_id');
            $table->string('spotify_url');
            $table->integer('total_tracks');
            $table->timestamps();
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete(('cascade'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
};
