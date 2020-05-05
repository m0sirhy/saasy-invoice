<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceLastSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function(Blueprint $table) {
                $table->integer('remind_days1')->default(0);
                $table->integer('remind_after1')->default(1);
                $table->integer('remind_enable1')->default(0);
                $table->integer('remind_days2')->default(0);
                $table->integer('remind_after2')->default(1);
                $table->integer('remind_enable2')->default(0);
                $table->integer('remind_days3')->default(0);
                $table->integer('remind_after3')->default(1);
                $table->integer('remind_enable3')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function(Blueprint $table) {
            $table->dropColumn('remind_days1');
            $table->dropColumn('remind_days2');
            $table->dropColumn('remind_days3');
            $table->dropColumn('remind_after1');
            $table->dropColumn('remind_after2');
            $table->dropColumn('remind_after3');
            $table->dropColumn('remind_enable1');
            $table->dropColumn('remind_enable2');
            $table->dropColumn('remind_enable3');
        });
    }
}
