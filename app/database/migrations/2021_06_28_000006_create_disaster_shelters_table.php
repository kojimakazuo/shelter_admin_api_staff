<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterSheltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disaster_shelters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disaster_id')->unsigned()->comment('災害ID');
            $table->foreign('disaster_id')->references('id')->on('disasters');
            $table->bigInteger('shelter_id')->unsigned()->comment('避難所ID');
            $table->foreign('shelter_id')->references('id')->on('shelters');
            $table->string('title')->comment('タイトル');
            $table->integer('capacity')->unsigned()->comment('収容可能人数');
            $table->datetime('start_at')->comment('開始日時');
            $table->datetime('end_at')->nullable()->comment('終了日時');
            $table->bigInteger('staff_user_id')->unsigned()->comment('担当者ID');
            $table->foreign('staff_user_id')->references('id')->on('staff_users');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disaster_shelters');
    }
}
