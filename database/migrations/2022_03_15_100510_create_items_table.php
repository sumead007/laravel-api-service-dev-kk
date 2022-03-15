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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('cus_id');
            $table->string('name_api')->comment="(ชื่อ api เช่น scb)";
            $table->integer('type_name_api')->comment = "0=ถอน, 1=ฝาก, 2=ถอนและฝาก";
            $table->integer('days_api')->comment = "(่เช่ากี่วัน)";
            $table->double('price_api');
            $table->integer('status')->comment="(ปรับโดยแอตมิน)0=ใช้ไม่ได้, 1=ใช้ได้";
            $table->string('comment')->comment="คอมเม้นจากแอตมิน";
            $table->string('token')->comment="token ทีั่ยังไม่เข้ารหัส";
            $table->dateTime('expire');
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
        Schema::dropIfExists('items');
    }
};
