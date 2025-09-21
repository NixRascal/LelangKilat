<?php

namespace App\Services;

use App\Repositories\AuctionRepository;
use App\Repositories\BidRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    public function __construct(
        private readonly AuctionRepository $auctions,
        private readonly BidRepository $bids,
    ) {}

    public function exportAuctions(array $filters = []): string
    {
        $paginator = $this->auctions->list($filters, $filters['sort'] ?? null);
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Judul', 'Status', 'Pemilik', 'Tawaran Tertinggi']);

        foreach ($paginator->items() as $item) {
            fputcsv($handle, [
                $item->id,
                $item->title,
                $item->status,
                $item->owner?->name,
                number_format($item->current_bid, 0, ',', '.'),
            ]);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        $filename = 'reports/auctions_'.now()->format('Ymd_His').'.csv';
        Storage::disk('local')->put($filename, $contents);

        return Storage::disk('local')->path($filename);
    }
}
