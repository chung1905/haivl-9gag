<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BigUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Crate tags table
        Schema::create('tags', function (Blueprint $table) {
            $table->string('tag_name');
        });
        # Edit config table
        DB::table('configs')->where('config_names', 'category')->delete();
        DB::table('configs')->insert([
            ['config_names' => 'min_trending_like', 'config_values' => 0],
            ['config_names' => 'min_hot_like', 'config_values' => 0]
        ]);
        # Edit posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('likes', 'like');
            $table->integer('dislike')->default(0);
            $table->string('tag')->references('tag_name')->on('tags');
        });
        # Create reaction table
        Schema::create('reaction', function (Blueprint $table) {
            $table->integer('post')->references('id')->on('posts');
            $table->integer('who')->references('id')->on('users');
            $table->boolean('is_like')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        # Drop tags table
        Schema::dropIfExists('tags');
        # Revert config table
        DB::table('configs')->insert(['config_names' => 'category', 'config_values' => 'Hot,Trending,Fresh']);
        DB::table('configs')->where('config_names', 'min_trending_like')->delete();
        DB::table('configs')->where('config_names', 'min_hot_like')->delete();
        # Revert posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('like', 'likes');
            $table->dropColumn(['dislike', 'tag']);
        });
        # Drop reaction table
        Schema::dropIfExists('reaction');
    }
}