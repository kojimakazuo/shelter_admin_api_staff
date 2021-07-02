<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entry_id')->unsigned()->comment('受付ID');
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->enum('type', ['Entry', 'Out', 'In', 'Exit'])->comment('履歴タイプ(入場, 一時退室, 再入場, 退場)');
            $table->timestamp('occurred_at')->comment('発生日時');
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
        Schema::dropIfExists('entry_histories');
    }
}
