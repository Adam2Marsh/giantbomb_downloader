<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeThumbnailPaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_details', function (Blueprint $table) {
            $table->string('remote_image_path')->nullable();
        });

        Schema::table('video_details', function (Blueprint $table) {
            $table->renameColumn('image_path', 'local_image_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_details', function (Blueprint $table) {
            $table->dropColumn('remote_image_path');
        });

        Schema::table('video_details', function (Blueprint $table) {
            $table->renameColumn('local_image_path', 'image_path');
        });
    }
}
