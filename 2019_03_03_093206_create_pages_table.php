<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->string('title');
	        $table->string('slug')->unique();
	        $table->text('meta_keywords');
	        $table->text('meta_desc');
	        $table->text('content');
	        $table->string('icon');
	        $table->boolean('published');
	        $table->dateTime('published_at');
	        $table->boolean('blog_post');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
