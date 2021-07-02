<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('避難所名');
            $table->string('name_kana')->comment('避難所名かな');
            $table->string('postal_code')->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->string('phone_number')->comment('電話番号');
            $table->double('latitude')->comment('所在地(緯度)');
            $table->double('longitude')->comment('所在地(経度)');
            $table->enum('type', ['Emergency', 'Normal'])->comment('避難所タイプ(緊急避難所, 避難所)');
            $table->enum('target_disaster_type', ['WindAndFlood', 'Rockfall', 'Earthquake', 'LargeScaleFire'])->comment('対象異常現象種類(風水害, がけ崩れ, 地震, 大規模火災)');
            $table->integer('capacity')->unsigned()->comment('収容可能人数');
            $table->text('facility_info')->comment('設備情報');
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
        Schema::dropIfExists('shelters');
    }
}
