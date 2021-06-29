<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalitySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipality_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('自治体名');
            $table->geometry('location')->comment('所在地');
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
        Schema::dropIfExists('municipality_settings');
    }
}
