<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn(['address', 'apartment', 'state']);

            $table->string('district', 255)->nullable()->after('city');
            $table->string('ward', 255)->nullable()->after('district');
            $table->string('street', 255)->nullable()->after('ward');
            $table->string('house_number', 255)->nullable()->after('street');
        });
    }

    public function down()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn(['district', 'ward', 'street', 'house_number']);

            $table->text('address')->nullable()->after('city');
            $table->string('apartment', 255)->nullable()->after('address');
            $table->string('state', 255)->nullable()->after('apartment');
        });
    }
};
