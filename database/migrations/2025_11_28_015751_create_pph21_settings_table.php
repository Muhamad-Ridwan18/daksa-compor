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
        Schema::create('pph21_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();
            $table->decimal('value', 15, 2);
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('category')->default('ptkp'); // ptkp, tarif, batas
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default values
        $defaults = [
            // PTKP
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_tk_0', 'value' => 54000000, 'label' => 'PTKP Tidak Kawin 0 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Tidak Kawin dengan 0 tanggungan', 'category' => 'ptkp', 'sort_order' => 1],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_tk_1', 'value' => 58500000, 'label' => 'PTKP Tidak Kawin 1 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Tidak Kawin dengan 1 tanggungan', 'category' => 'ptkp', 'sort_order' => 2],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_tk_2', 'value' => 63000000, 'label' => 'PTKP Tidak Kawin 2 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Tidak Kawin dengan 2 tanggungan', 'category' => 'ptkp', 'sort_order' => 3],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_tk_3', 'value' => 67500000, 'label' => 'PTKP Tidak Kawin 3 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Tidak Kawin dengan 3 tanggungan', 'category' => 'ptkp', 'sort_order' => 4],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_k_0', 'value' => 58500000, 'label' => 'PTKP Kawin 0 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Kawin dengan 0 tanggungan', 'category' => 'ptkp', 'sort_order' => 5],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_k_1', 'value' => 63000000, 'label' => 'PTKP Kawin 1 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Kawin dengan 1 tanggungan', 'category' => 'ptkp', 'sort_order' => 6],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_k_2', 'value' => 67500000, 'label' => 'PTKP Kawin 2 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Kawin dengan 2 tanggungan', 'category' => 'ptkp', 'sort_order' => 7],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_k_3', 'value' => 72000000, 'label' => 'PTKP Kawin 3 Tanggungan', 'description' => 'Penghasilan Tidak Kena Pajak untuk Kawin dengan 3 tanggungan', 'category' => 'ptkp', 'sort_order' => 8],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'ptkp_tambahan', 'value' => 4500000, 'label' => 'PTKP Tambahan per Tanggungan', 'description' => 'PTKP tambahan untuk setiap tanggungan lebih dari 3', 'category' => 'ptkp', 'sort_order' => 9],
            
            // Tarif Pajak
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'tarif_5_persen', 'value' => 0.05, 'label' => 'Tarif Pajak 5%', 'description' => 'Tarif pajak untuk lapisan pertama (sampai 60 juta)', 'category' => 'tarif', 'sort_order' => 10],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'tarif_15_persen', 'value' => 0.15, 'label' => 'Tarif Pajak 15%', 'description' => 'Tarif pajak untuk lapisan kedua (60 juta - 250 juta)', 'category' => 'tarif', 'sort_order' => 11],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'tarif_25_persen', 'value' => 0.25, 'label' => 'Tarif Pajak 25%', 'description' => 'Tarif pajak untuk lapisan ketiga (250 juta - 500 juta)', 'category' => 'tarif', 'sort_order' => 12],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'tarif_30_persen', 'value' => 0.30, 'label' => 'Tarif Pajak 30%', 'description' => 'Tarif pajak untuk lapisan keempat (di atas 500 juta)', 'category' => 'tarif', 'sort_order' => 13],
            
            // Batas Lapisan
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'batas_lapisan_1', 'value' => 60000000, 'label' => 'Batas Lapisan 1', 'description' => 'Batas atas untuk lapisan tarif pertama (60 juta)', 'category' => 'batas', 'sort_order' => 14],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'batas_lapisan_2', 'value' => 250000000, 'label' => 'Batas Lapisan 2', 'description' => 'Batas atas untuk lapisan tarif kedua (250 juta)', 'category' => 'batas', 'sort_order' => 15],
            ['id' => \Illuminate\Support\Str::uuid(), 'key' => 'batas_lapisan_3', 'value' => 500000000, 'label' => 'Batas Lapisan 3', 'description' => 'Batas atas untuk lapisan tarif ketiga (500 juta)', 'category' => 'batas', 'sort_order' => 16],
        ];

        foreach ($defaults as $default) {
            \DB::table('pph21_settings')->insert($default);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pph21_settings');
    }
};
