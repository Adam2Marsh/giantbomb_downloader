<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id');
            $table->integer('service_video_id');
            $table->text('name');
            $table->text('description');
            $table->text('video_url');
            $table->text('thumbnail_url');
            $table->text('thumbnail_local_url')->nullable();
            $table->bigInteger('size')->nullable();
            $table->text('state');
            $table->dateTime('published_date');
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
        Schema::dropIfExists('videos');
    }
}
