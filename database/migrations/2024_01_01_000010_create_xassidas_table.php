<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xassidas', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('titre');
            $table->string('titre_arabe');
            $table->string('auteur')->default('');
            $table->text('description')->default('');
            $table->string('categorie')->default('Druuss');
            $table->text('poeme')->default('');
            $table->jsonb('versets')->default('[]');
            $table->jsonb('pdfs')->default('[]');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xassidas');
    }
};
