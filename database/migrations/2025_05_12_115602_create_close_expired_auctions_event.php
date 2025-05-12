<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Aktifkan scheduler (jika belum)
        DB::statement("SET GLOBAL event_scheduler = ON;");

        // Buat event kalau belum ada
        DB::unprepared(<<<'SQL'
        CREATE EVENT IF NOT EXISTS `close_expired_auctions`
          ON SCHEDULE EVERY 1 MINUTE
          COMMENT 'Tutup lelang yang sudah habis waktu'
        DO
          UPDATE `auctions`
            SET `status`      = 'CLOSED',
                `winner_id`   = `highest_bidder_id`,
                `final_price` = `current_bid`
          WHERE `status` = 'ACTIVE'
            AND `end_time` <= NOW();
        SQL);
    }

    public function down(): void
    {
        DB::unprepared("DROP EVENT IF EXISTS `close_expired_auctions`;");
    }
};
