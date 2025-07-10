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
        Schema::create('coordinates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('scene_tag_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // $table->boolean('is_public')->default(false);
            $table->string('memo', 100)->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->softDeletes(); // ←deleted_atカラム追加
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinates');
    }
};
