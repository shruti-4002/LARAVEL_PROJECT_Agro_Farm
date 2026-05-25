<?php

namespace App\Services;

use App\Models\Crop;
use Illuminate\Support\Facades\Http;

class MandiPriceService
{
    public function rows(?string $region = null): array
    {
        $liveRows = $this->liveRows($region);

        return count($liveRows) ? $liveRows : Crop::pricesForRegion($region);
    }

    private function liveRows(?string $region): array
    {
        $apiKey = (string) config('services.mandi.key');

        if (trim($apiKey) === '') {
            return [];
        }

        $query = [
            'api-key' => $apiKey,
            'format' => 'json',
            'limit' => 60,
        ];

        if ($region !== null && trim($region) !== '') {
            $query['filters[state]'] = $region;
        }

        try {
            $response = Http::timeout(20)->acceptJson()->get(config('services.mandi.url'), $query);

            if ($response->failed()) {
                return [];
            }

            return collect($response->json('records', []))
                ->map(fn ($record) => $this->mapRecord($record))
                ->filter()
                ->values()
                ->all();
        } catch (\Throwable) {
            return [];
        }
    }

    private function mapRecord(array $record): ?array
    {
        $price = $record['modal_price'] ?? null;

        if ($price === null || $price === '') {
            return null;
        }

        return [
            'crop' => $record['commodity'] ?? 'Unknown',
            'category' => 'Live mandi',
            'region' => $record['state'] ?? '',
            'mandi' => $record['market'] ?? '',
            'price' => (float) str_replace(',', '', (string) $price),
            'unit' => 'quintal',
            'change_percent' => 0,
            'source' => 'data.gov.in',
            'updated_at' => $record['arrival_date'] ?? now()->toDateString(),
        ];
    }
}
