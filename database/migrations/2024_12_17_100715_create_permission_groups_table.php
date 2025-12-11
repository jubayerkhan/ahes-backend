<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission_groups', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('user_id')->default(0);
          $table->string('key')->nullable();
          $table->string('type', 50)->nullable();
          $table->string('name')->nullable();
          $table->integer('priority')->default(0);
          $table->boolean('status')->default(0);
          $table->timestamps();
          $table->softDeletes();
          $table->unique(['key', 'type'], 'key_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_groups');
    }
};
