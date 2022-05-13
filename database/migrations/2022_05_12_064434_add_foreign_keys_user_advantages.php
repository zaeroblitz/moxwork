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
        Schema::table('user_advantages', function (Blueprint $table) {
            $table->foreignId('services_id')->nullable()->index('fk_user_advantages_to_services')->change();

            $table->foreign('services_id', 'fk_user_advantages_to_services')
            ->references('id')->on('services')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_advantages', function (Blueprint $table) {
            $table->dropForeign('fk_user_advantages_to_services');
        });
    }
};