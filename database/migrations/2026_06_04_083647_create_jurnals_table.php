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
    Schema::create('jurnals', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('keterangan');
        $table->decimal('total_debit', 15, 2)->default(0);
        $table->decimal('total_kredit', 15, 2)->default(0);
        $table->enum('status', ['draft', 'posted'])->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
