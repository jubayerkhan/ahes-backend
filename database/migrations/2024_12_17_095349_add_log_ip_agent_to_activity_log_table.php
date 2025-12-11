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
    Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
      $table->string('log_ip')->nullable()->after('batch_uuid');
      $table->text('log_ip_country')->nullable()->after('log_ip');
      $table->text('log_user_agent')->nullable()->after('log_ip_country');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
      $table->dropColumn('log_ip', 'log_ip_country', 'log_user_agent');
    });
  }
};
