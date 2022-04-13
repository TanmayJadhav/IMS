<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('operators', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('reasons', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('sell_products', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->string('shop_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('table', function (Blueprint $table) {
        //     //
        // });
    }
}
