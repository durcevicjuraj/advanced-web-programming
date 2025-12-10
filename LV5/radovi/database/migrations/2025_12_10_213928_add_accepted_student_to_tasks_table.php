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
    Schema::table('tasks', function (Blueprint $table) {
        $table->foreignId('accepted_student_id')->nullable()->constrained('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropForeign(['accepted_student_id']);
        $table->dropColumn('accepted_student_id');
    });
}
};
