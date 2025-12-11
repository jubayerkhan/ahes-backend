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
        Schema::table('roles', function (Blueprint $table) {
            $table->bigInteger('action_id')->default(0)->after('id');
            $table->string('type', 50)->nullable()->after('name');
            $table->boolean('status')->default(0)->after('description');
            $table->softDeletes();

            $table->dropUnique('roles_name_unique');
            $table->unique(['name', 'type'], 'name_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('action_id', 'type', 'status');
            $table->dropSoftDeletes();

            $table->unique('name');
            $table->dropUnique('name_type_unique');
        });
    }
};
