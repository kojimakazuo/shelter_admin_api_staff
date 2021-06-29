<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_sheets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disaster_id')->unsigned()->comment('災害ID');
            $table->foreign('disaster_id')->references('id')->on('disasters');
            $table->enum('type', ['Web', 'Paper'])->comment('受付タイプ(WEB, 紙)');
            $table->string('name')->comment('代表者氏名');
            $table->string('name_kana')->comment('代表者氏名かな');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('created_by')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->timestamp('updated_by')->useCurrent()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_sheets');
    }
}
