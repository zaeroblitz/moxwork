<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_experiences', function (Blueprint $table) {            
            $table->foreignId('user_details_id')->nullable()->index('fk_user_experiences_to_user_details')->change();

            $table->foreign('user_details_id', 'fk_user_experiences_to_user_details')
            ->references('id')->on('user_details')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_experiences', function (Blueprint $table) {
            $table->dropForeign('fk_user_experiences_to_user_details');
        });
    }
};