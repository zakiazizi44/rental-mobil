<?php

namespace App\Console\Commands;

use App\Services\BookingCsvService;
use Illuminate\Console\Command;

class ExportBookingsCsv extends Command
{
    protected $signature = 'bookings:export-csv
                            {--force : Tulis ulang seluruh file CSV dari database}';

    protected $description = 'Menulis seluruh data booking ke file CSV (storage/app/private/exports/bookings.csv)';

    public function handle(BookingCsvService $csv): int
    {
        if ($csv->exists() && ! $this->option('force')) {
            $this->warn('File CSV sudah ada: ' . $csv->absolutePath());
            $this->line('Gunakan --force untuk menulis ulang seluruh data dari database.');

            return self::SUCCESS;
        }

        $csv->writeAll();

        $this->info('File CSV berhasil ditulis: ' . $csv->absolutePath());

        return self::SUCCESS;
    }
}