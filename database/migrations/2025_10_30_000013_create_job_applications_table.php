<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->string('status')->default('received'); // received, reviewed, interviewed, rejected, offer
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('vacancies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};


