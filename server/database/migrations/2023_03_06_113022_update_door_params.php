<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDoorParams extends Migration
{
    const PRICE = 'price';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('door_params', function (Blueprint $table) {
            $table->decimal(self::PRICE, 7, 0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('door_params', function (Blueprint $table) {
            $table->dropColumn(self::PRICE);
        });
    }
}