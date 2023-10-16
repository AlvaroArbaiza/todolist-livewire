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
        Schema::table('to_dos', function (Blueprint $table) {
            // Inserimento foreign key('user_id') nella tabella to_dos, di tipo intero positivo, potrà essere di tipo nullo e alla cancellazione dell'utente i record non verranno cancellati ma il campo verrà settato su null
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('to_dos', function (Blueprint $table) {
            $table->dropForeign('to_dos_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
