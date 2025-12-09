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
        Schema::create('ter_tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('kategori', ['TER A', 'TER B', 'TER C']);
            $table->decimal('min', 15, 2);
            $table->decimal('max', 15, 2);
            $table->decimal('tarif_percent', 5, 2);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['kategori', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ter_tables');
    }
};
