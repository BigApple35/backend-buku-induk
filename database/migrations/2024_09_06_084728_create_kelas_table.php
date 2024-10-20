<?php

use App\Models\Angkatan;
use App\Models\BagianKelas;
use App\Models\Jurusan;
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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->foreignIdFor(Jurusan::class);
            $table->foreignIdFor(BagianKelas::class);
            $table->foreignIdFor(Angkatan::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
