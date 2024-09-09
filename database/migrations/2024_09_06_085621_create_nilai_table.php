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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai_r');
            $table->text('keterangan');
            $table->unsignedBigInteger('mapel_id');
            $table->unsignedBigInteger('semester_id');
            $table->timestamps();

            //foreign key
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
