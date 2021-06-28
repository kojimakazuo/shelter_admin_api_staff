<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrySheetWebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_sheet_webs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entry_sheet_id')->unsigned()->comment('受付シートID');
            $table->foreign('entry_sheet_id')->references('id')->on('entry_sheets');
            $table->date('birthday')->comment('代表者生年月日');
            $table->enum('gender', ['Male', 'Female'])->comment('代表者性別');
            $table->float('temperature')->comment('代表者体温');
            $table->string('postal_code')->comment('代表者郵便番号');
            $table->string('address')->comment('代表者住所');
            $table->string('phone_number')->comment('代表者電話番号');
            $table->enum('companion', ['None', 'Family', 'Other'])->comment('同行者(なし, 家族, その他)');
            $table->boolean('stay_in_car')->comment('車中泊');
            $table->integer('number_of_in_car')->unsigned()->comment('車中泊人数');
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
        Schema::dropIfExists('entry_sheet_webs');
    }
}
