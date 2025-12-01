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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('document_number')->nullable();
            $table->text('description');
            $table->text('excerpt')->nullable();
            $table->date('published_date');
            $table->boolean('is_new')->default(false);
            $table->string('document_file')->nullable(); // Path to PDF file
            $table->string('document_url')->nullable(); // External URL if document is hosted elsewhere
            $table->json('categories')->nullable(); // ['PPh', 'PPN', 'Lainnya']
            $table->string('source')->nullable(); // e.g., "Kementerian Keuangan"
            $table->string('document_type')->nullable(); // Keputusan, Peraturan, Surat Edaran, etc.
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
