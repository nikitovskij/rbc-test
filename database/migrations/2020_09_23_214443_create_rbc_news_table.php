<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRbcNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rbc_news', function (Blueprint $table) {
            $table->id();
            $table->string('feed_id')->unique();
            $table->string('link')->unique();
            $table->string('header');
            $table->text('overview')->nullable();
            $table->string('image_link')->nullable();
            $table->string('image_title')->nullable();
            $table->string('content_authors')->nullable();
            $table->text('content')->nullable();
            $table->timestamp('date_modified', 0);
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
        Schema::dropIfExists('rbc_news');
    }
}
