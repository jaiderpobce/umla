<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones_import_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('original_file_name', 255);
            $table->string('csv_file_name', 255)->nullable();
            $table->string('status', 30)->default('completed');
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->json('invalid_rows_preview')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index('user_id', 'calif_import_histories_user_id_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones_import_histories');
    }
};