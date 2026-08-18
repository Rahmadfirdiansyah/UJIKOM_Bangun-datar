<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
                      // Pastikan kolom 'result' ada sebelum mencoba mengubahnya
            if (Schema::hasColumn('calculations', 'result')) {
                $table->text('result')->change();
            }
            
            // Modifikasi kolom 'shape'
            $table->string('shape')->default('unknown')->change();
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->string('result')->nullable()->change(); // Kembalikan perubahan jika perlu
            $table->string('shape')->default(null)->change();
        });
    }

};
