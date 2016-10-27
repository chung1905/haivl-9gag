<?php

//use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordsToConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('configs')->insert([
            ['config_names' => 'max_size', 'config_values' => '1024'], // dung luong toi da cua 1 buc anh la 1mb
            ['config_names' => 'posts_per_page', 'config_values' => '10'], // moi trang 10 post
            ['config_names' => 'category', 'config_values' => 'Hot,Trending,Fresh'] // 3 category chinh
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('configs')->truncate();
    }
}