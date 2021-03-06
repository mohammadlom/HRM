<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('subject');
            $table->timestamps();
        });

        Schema::table('demands', function (Blueprint $table) {
            $table->foreign('status_id')
                ->references('id')->on('statuses')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('dismissal_hours', function (Blueprint $table) {
            $table->foreign('demand_id')
                ->references('id')->on('demands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->dropForeign(['status_id', 'user_id']);
        });
        Schema::dropIfExists('demands');
    }
}
