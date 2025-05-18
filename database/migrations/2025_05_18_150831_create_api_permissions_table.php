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
        Schema::create('api_permissions', function (Blueprint $table) {
            $table->id();
            $table->enum('action', ['create', 'read', 'update', 'delete'])->default('read');
            $table->string('resource');
            $table->string('label');
            $table->timestamps();

            $table->unique(['action', 'resource']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_permissions');
    }
};
