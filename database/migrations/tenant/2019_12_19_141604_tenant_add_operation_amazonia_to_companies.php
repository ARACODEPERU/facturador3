<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddOperationAmazoniaToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('operation_amazonia')->default(false)->after('logo_store');
            $table->string('holder')->nullable()->after('operation_amazonia');
            $table->string('holder_number')->nullable()->after('holder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('holder_number');
            $table->dropColumn('holder');
            $table->dropColumn('operation_amazonia');
        });
    }
}
