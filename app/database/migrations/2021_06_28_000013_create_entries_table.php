<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disaster_shelter_id')->unsigned()->comment('災害避難所ID');
            $table->foreign('disaster_shelter_id')->references('id')->on('disaster_shelters');
            $table->bigInteger('entry_sheet_id')->unsigned()->comment('受付シートID');
            $table->foreign('entry_sheet_id')->references('id')->on('entry_sheets');
            $table->datetime('enterd_at')->comment('入場日時');
            $table->datetime('exited_at')->nullable()->comment('退場日時');
            $table->enum('site_type', ['General', 'BadCondition', 'Car'])->comment('避難場所タイプ(一般, 体調不良者向け, 車中泊)');
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
        Schema::dropIfExists('entries');
    }
}
