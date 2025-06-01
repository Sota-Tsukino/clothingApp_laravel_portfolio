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
        Schema::create('body_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('measured_at');
            $table->decimal('height', 4, 1)->unsigned()->nullable();// float精度が劣るのでdecimal()を使用
            $table->decimal('head_circumference', 4, 1)->unsigned()->nullable();// 99.9まで　小数点以下の桁数1
            $table->decimal('kitake_length', 4, 1)->unsigned()->nullable();
            $table->decimal('neck_circumference', 4, 1)->unsigned()->nullable();
            $table->decimal('shoulder_width', 4, 1)->unsigned()->nullable();
            $table->decimal('chest_circumference', 4, 1)->unsigned()->nullable();
            $table->decimal('armpit_to_armpit_width', 4, 1)->unsigned()->nullable();
            $table->decimal('waist', 4, 1)->unsigned()->nullable();
            $table->decimal('hip', 4, 1)->unsigned()->nullable();
            $table->decimal('sleeve_length', 4, 1)->unsigned()->nullable();
            $table->decimal('yuki_length', 4, 1)->unsigned()->nullable();
            $table->decimal('inseam', 4, 1)->unsigned()->nullable();
            $table->decimal('foot_length', 4, 1)->unsigned()->nullable();
            $table->decimal('foot_circumference', 4, 1)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_measurements');
    }
};
