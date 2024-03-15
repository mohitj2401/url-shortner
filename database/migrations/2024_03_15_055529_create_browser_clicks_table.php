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
        Schema::create('browser_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('short_url_id')->constrained()->cascadeOnDelete();
            $table->string('browser');
            $table->integer('clicks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('browser_clicks');
    }
};
