<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEntrySheetPaperCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_sheet_paper_companions', function (Blueprint $table) {
            $table->string('temperature')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_sheet_paper_companions', function (Blueprint $table) {
            $table->string('temperature')->nullable(false)->change();
        });
    }
}
