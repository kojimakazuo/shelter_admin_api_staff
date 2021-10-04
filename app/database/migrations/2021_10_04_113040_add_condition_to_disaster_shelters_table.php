<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionToDisasterSheltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disaster_shelters', function (Blueprint $table) {
            $table->enum('condition', ['Available', 'Unavailable'])->default('Available')->comment('状態(利用可能, 利用不可)')->after('staff_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disaster_shelters', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
    }
}
