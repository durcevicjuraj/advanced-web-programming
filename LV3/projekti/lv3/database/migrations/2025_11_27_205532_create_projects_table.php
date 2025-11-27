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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('naziv_projekta');
        $table->text('opis_projekta');
        $table->decimal('cijena_projekta', 10, 2);
        $table->text('obavljeni_poslovi')->nullable();
        $table->date('datum_pocetka');
        $table->date('datum_zavrsetka')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // voditelj projekta
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
