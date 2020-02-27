<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValuesForBillingItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('billing_items', 'after_min')) {
            Schema::table('billing_items', function($table) {
                $table->dropColumn(['after_min']);
            });
        }
        Schema::table('billing_items', function($table) {
            $table->integer('after_min')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
