<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrySheetPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_sheet_papers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entry_sheet_id')->unsigned()->comment('受付シートID');
            $table->foreign('entry_sheet_id')->references('id')->on('entry_sheets');
            $table->string('sheet_number')->comment('シート番号');
            $table->enum('gender', ['Male', 'Female'])->comment('代表者性別');
            $table->float('temperature')->comment('代表者体温');
            $table->string('front_sheet_image_url')->comment('表チェックシートURL');
            $table->string('back_sheet_image_url')->comment('裏チェックシートURL');
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
        Schema::dropIfExists('entry_sheet_papers');
    }
}
