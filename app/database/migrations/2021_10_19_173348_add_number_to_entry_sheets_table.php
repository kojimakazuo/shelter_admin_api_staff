<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberToEntrySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_sheets', function (Blueprint $table) {
            $table->integer('number_of_evacuees')->unsigned()->default(1)->comment('避難者数')->after('name_kana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_sheets', function (Blueprint $table) {
            $table->dropColumn('number_of_evacuees');
        });
    }
}
