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
        Schema::table('ticket_types', function (Blueprint $table) {
            // Cek apakah kolom 'quantity' BELUM ADA, baru tambahkan
            if (!Schema::hasColumn('ticket_types', 'quota')) {
                $table->integer('quota')->default(0)->after('price');
            }

            // Cek apakah kolom 'sold' BELUM ADA, baru tambahkan
            if (!Schema::hasColumn('ticket_types', 'sold')) {
                $table->integer('sold')->default(0)->after('quota');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            // Cek apakah kolomnya ADA, baru hapus
            if (Schema::hasColumn('ticket_types', 'quota')) {
                $table->dropColumn('quota');
            }
            if (Schema::hasColumn('ticket_types', 'sold')) {
                $table->dropColumn('sold');
            }
        });
    }
};