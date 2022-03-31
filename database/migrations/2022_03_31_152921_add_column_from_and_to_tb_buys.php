<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('from_account')->comment = "โอนจากบัญชี";
            $table->string('from_no_account')->comment = "เลขที่บัญชี";
            $table->string('from_name_account')->comment = "ชื่อคนโอน";
            $table->string('to_account')->comment = "โอนไปยังบัญชี";
            $table->string('to_no_account')->comment = "โอนไปยังเลขที่บัญชี";
            $table->string('to_name_account')->comment = "ชื่อปลายทาง";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        //

    }
};
