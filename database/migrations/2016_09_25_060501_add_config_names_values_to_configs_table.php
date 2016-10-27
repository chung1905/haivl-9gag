<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigNamesValuesToConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->string('config_names');
            $table->string('config_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            if (Schema::hasColumn('configs', 'config_names')) {
                $table->dropColumn(['config_names']);
            }
            if (Schema::hasColumn('configs', 'config_values')) {
                $table->dropColumn(['config_values']);
            }
        });
    }
}
