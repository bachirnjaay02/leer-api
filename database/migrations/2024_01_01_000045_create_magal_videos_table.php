<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('magal_videos', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('file_path'); // chemin relatif dans storage/app/public/magal/
            $table->string('url');       // URL publique
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magal_videos');
    }
};
