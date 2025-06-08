<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin', 'admin', 'user') DEFAULT 'user'");
}

    /**
     * Reverse the migrations.
     */
  public function down(): void
    {
        // Kembalikan enum role ke kondisi awal (tanpa super_admin)
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') DEFAULT 'user'");
    }
};
