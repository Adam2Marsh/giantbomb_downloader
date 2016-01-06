<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_statuses', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('gb_Id')->index();
            $table->string('url');
            $table->timestamp('published_date');
            $table->timestamp('created_at')->index();
            $table->string('status');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('video_statuses');
    }
}
