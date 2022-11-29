<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->string('origin_longtitude')->nullable()->after('origin');
            $table->string('origin_latitude')->nullable()->after('origin');
            $table->string('destination_longtitude')->nullable()->after('destination');
            $table->string('destination_latitude')->nullable()->after('destination');
            $table->string('current_location')->nullable()->afer('destination_latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shippings', function (Blueprint $table) {
            //
        });
    }
}
