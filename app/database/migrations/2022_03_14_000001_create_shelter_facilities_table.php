<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelterFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelter_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(1)->comment('表示順');
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
        Schema::dropIfExists('shelter_facilities');
    }
}
