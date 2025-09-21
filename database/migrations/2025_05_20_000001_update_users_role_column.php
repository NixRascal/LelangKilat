<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'preferences')) {
            Schema::table('users', function (Blueprint $table) {
                $table->json('preferences')->nullable();
            });
        }

        if (Schema::hasColumn('users', 'role') && DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(20) NOT NULL DEFAULT 'user'");
            DB::table('users')->update(['role' => DB::raw("LOWER(role)")]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'preferences')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('preferences');
            });
        }

        if (Schema::hasColumn('users', 'role') && DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('USER','ADMIN') NOT NULL DEFAULT 'USER'");
        }
    }
};
