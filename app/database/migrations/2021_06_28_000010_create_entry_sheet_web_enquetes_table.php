<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrySheetWebEnquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_sheet_web_enquetes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entry_sheet_web_id')->unsigned()->comment('WEB受付シートID');
            $table->foreign('entry_sheet_web_id')->references('id')->on('entry_sheet_webs');
            $table->json('data')->comment('JSONデータ');
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
        Schema::dropIfExists('entry_sheet_web_enquetes');
    }
}
