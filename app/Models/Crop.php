<?php

namespace App\Models;

use App\Services\MongoService;

class Crop
{
    public const COLLECTION = 'crops';

    public static function all(): array
    {
        return app(MongoService::class)->find(self::COLLECTION, [], ['sort' => ['name' => 1]]);
    }

    public static function findByName(string $name): ?array
    {
        return app(MongoService::class)->findOne(self::COLLECTION, ['name' => trim($name)]);
    }

    public static function regions(): array
    {
        $regions = [];

        foreach (self::all() as $crop) {
            foreach (($crop['local_prices'] ?? []) as $price) {
                $regions[$price['region']] = true;
            }
        }

        $regions = array_keys($regions);
        sort($regions);

        return $regions;
    }

    public static function pricesForRegion(?string $region): array
    {
        $rows = [];

        foreach (self::all() as $crop) {
            foreach (($crop['local_prices'] ?? []) as $price) {
                if ($region === null || $region === '' || $price['region'] === $region) {
                    $rows[] = [
                        'crop' => $crop['name'],
                        'unit' => $crop['unit'],
                        'category' => $crop['category'],
                        ...$price,
                    ];
                }
            }
        }

        usort($rows, fn ($a, $b) => [$a['region'], $a['crop']] <=> [$b['region'], $b['crop']]);

        return $rows;
    }

    public static function seedDefaults(): void
    {
        $crops = [
            self::crop('Wheat', 'Grain', 'quintal', 'Rabi', [
                ['region' => 'Punjab', 'mandi' => 'Ludhiana', 'price' => 2425, 'change_percent' => 1.8],
                ['region' => 'Haryana', 'mandi' => 'Karnal', 'price' => 2380, 'change_percent' => 0.9],
                ['region' => 'Uttar Pradesh', 'mandi' => 'Meerut', 'price' => 2315, 'change_percent' => -0.4],
            ]),
            self::crop('Rice', 'Grain', 'quintal', 'Kharif', [
                ['region' => 'Punjab', 'mandi' => 'Amritsar', 'price' => 3180, 'change_percent' => 2.1],
                ['region' => 'West Bengal', 'mandi' => 'Burdwan', 'price' => 2960, 'change_percent' => 0.6],
                ['region' => 'Tamil Nadu', 'mandi' => 'Thanjavur', 'price' => 3025, 'change_percent' => 1.2],
            ]),
            self::crop('Maize', 'Grain', 'quintal', 'Kharif', [
                ['region' => 'Karnataka', 'mandi' => 'Davanagere', 'price' => 2260, 'change_percent' => 1.1],
                ['region' => 'Bihar', 'mandi' => 'Purnia', 'price' => 2140, 'change_percent' => -0.8],
                ['region' => 'Madhya Pradesh', 'mandi' => 'Chhindwara', 'price' => 2195, 'change_percent' => 0.3],
            ]),
            self::crop('Tomato', 'Vegetable', 'quintal', 'All season', [
                ['region' => 'Maharashtra', 'mandi' => 'Nashik', 'price' => 1680, 'change_percent' => 5.2],
                ['region' => 'Karnataka', 'mandi' => 'Kolar', 'price' => 1540, 'change_percent' => 3.4],
                ['region' => 'Delhi NCR', 'mandi' => 'Azadpur', 'price' => 1880, 'change_percent' => 4.1],
            ]),
            self::crop('Potato', 'Vegetable', 'quintal', 'Rabi', [
                ['region' => 'Uttar Pradesh', 'mandi' => 'Agra', 'price' => 1280, 'change_percent' => -1.0],
                ['region' => 'West Bengal', 'mandi' => 'Hooghly', 'price' => 1365, 'change_percent' => 0.7],
                ['region' => 'Gujarat', 'mandi' => 'Deesa', 'price' => 1320, 'change_percent' => 0.2],
            ]),
            self::crop('Onion', 'Vegetable', 'quintal', 'Rabi', [
                ['region' => 'Maharashtra', 'mandi' => 'Lasalgaon', 'price' => 2210, 'change_percent' => 2.8],
                ['region' => 'Gujarat', 'mandi' => 'Mahuva', 'price' => 2075, 'change_percent' => 1.6],
                ['region' => 'Karnataka', 'mandi' => 'Hubballi', 'price' => 2130, 'change_percent' => 2.0],
            ]),
            self::crop('Cotton', 'Fiber', 'quintal', 'Kharif', [
                ['region' => 'Gujarat', 'mandi' => 'Rajkot', 'price' => 7060, 'change_percent' => 0.5],
                ['region' => 'Maharashtra', 'mandi' => 'Akola', 'price' => 6920, 'change_percent' => -0.2],
                ['region' => 'Telangana', 'mandi' => 'Warangal', 'price' => 7140, 'change_percent' => 1.4],
            ]),
            self::crop('Soybean', 'Oilseed', 'quintal', 'Kharif', [
                ['region' => 'Madhya Pradesh', 'mandi' => 'Indore', 'price' => 4625, 'change_percent' => 1.9],
                ['region' => 'Maharashtra', 'mandi' => 'Latur', 'price' => 4550, 'change_percent' => 1.1],
                ['region' => 'Rajasthan', 'mandi' => 'Kota', 'price' => 4685, 'change_percent' => 2.3],
            ]),
            self::crop('Mustard', 'Oilseed', 'quintal', 'Rabi', [
                ['region' => 'Rajasthan', 'mandi' => 'Jaipur', 'price' => 5520, 'change_percent' => 0.9],
                ['region' => 'Haryana', 'mandi' => 'Hisar', 'price' => 5480, 'change_percent' => 0.4],
                ['region' => 'Madhya Pradesh', 'mandi' => 'Morena', 'price' => 5575, 'change_percent' => 1.2],
            ]),
            self::crop('Sugarcane', 'Cash crop', 'tonne', 'Annual', [
                ['region' => 'Uttar Pradesh', 'mandi' => 'Muzaffarnagar', 'price' => 3720, 'change_percent' => 0.1],
                ['region' => 'Maharashtra', 'mandi' => 'Kolhapur', 'price' => 3580, 'change_percent' => 0.0],
                ['region' => 'Karnataka', 'mandi' => 'Mandya', 'price' => 3635, 'change_percent' => 0.3],
            ]),
        ];

        $mongo = app(MongoService::class);

        foreach ($crops as $crop) {
            $mongo->upsertDocument(self::COLLECTION, ['name' => $crop['name']], $crop);
        }
    }

    private static function crop(string $name, string $category, string $unit, string $season, array $prices): array
    {
        return [
            'name' => $name,
            'category' => $category,
            'unit' => $unit,
            'season' => $season,
            'local_prices' => array_map(fn ($price) => [
                ...$price,
                'source' => 'Seeded mandi sample',
                'updated_at' => now()->toDateTimeString(),
            ], $prices),
        ];
    }
}
