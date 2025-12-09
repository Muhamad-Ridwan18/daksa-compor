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
        Schema::create('pph_badan_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();
            $table->decimal('value', 15, 2);
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('category')->default('umum'); // umum, tarif, fasilitas
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default values
        $defaults = [
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'batas_fasilitas_min', 'value' => 4800000000, 'label' => 'Batas Fasilitas Minimum', 'description' => 'Batas minimum omzet untuk mendapat fasilitas (4,8 M)', 'category' => 'fasilitas', 'sort_order' => 1],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'batas_fasilitas_max', 'value' => 50000000000, 'label' => 'Batas Fasilitas Maximum', 'description' => 'Batas maximum omzet untuk mendapat fasilitas (50 M)', 'category' => 'fasilitas', 'sort_order' => 2],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'tarif_pph_badan', 'value' => 0.22, 'label' => 'Tarif PPh Badan', 'description' => 'Tarif PPh Badan default (22%)', 'category' => 'tarif', 'sort_order' => 3],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'persentase_fasilitas', 'value' => 0.50, 'label' => 'Persentase Fasilitas', 'description' => 'Persentase pengurangan tarif untuk fasilitas (50%)', 'category' => 'fasilitas', 'sort_order' => 4],
        ];

        foreach ($defaults as $default) {
            \DB::table('pph_badan_settings')->insert($default);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pph_badan_settings');
    }
};
