<?php

namespace App\Models;

use App\Services\MongoService;
use RuntimeException;

class Product
{
    public const COLLECTION = 'products';

    public static function create(array $attributes, array $farmer): string
    {
        return app(MongoService::class)->insertOne(self::COLLECTION, [
            'farmer_id' => $farmer['_id'],
            'farmer_name' => $farmer['name'],
            'crop_name' => trim($attributes['crop_name']),
            'region' => trim($attributes['region']),
            'quantity' => (float) $attributes['quantity'],
            'unit' => trim($attributes['unit']),
            'price' => (float) $attributes['price'],
            'description' => trim($attributes['description'] ?? ''),
            'status' => 'active',
        ]);
    }

    public static function find(string $id): ?array
    {
        return app(MongoService::class)->findOne(self::COLLECTION, ['_id' => $id]);
    }

    public static function active(): array
    {
        return app(MongoService::class)->find(self::COLLECTION, ['status' => 'active'], [
            'sort' => ['created_at' => -1],
        ]);
    }

    public static function byFarmer(string $farmerId): array
    {
        return app(MongoService::class)->find(self::COLLECTION, ['farmer_id' => $farmerId], [
            'sort' => ['created_at' => -1],
        ]);
    }

    public static function othersForFarmer(string $farmerId): array
    {
        return array_values(array_filter(self::active(), fn ($product) => $product['farmer_id'] !== $farmerId));
    }

    public static function decrementQuantity(string $productId, float $quantity): array
    {
        $product = self::find($productId);

        if (! $product || ($product['status'] ?? null) !== 'active') {
            throw new RuntimeException('This crop is no longer available.');
        }

        if ($quantity <= 0) {
            throw new RuntimeException('Quantity should be greater than zero.');
        }

        if ($quantity > (float) $product['quantity']) {
            throw new RuntimeException('Requested quantity is more than available stock.');
        }

        $remaining = round(((float) $product['quantity']) - $quantity, 2);

        app(MongoService::class)->updateOne(self::COLLECTION, ['_id' => $productId], [
            '$set' => [
                'quantity' => $remaining,
                'status' => $remaining > 0 ? 'active' : 'sold_out',
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);

        $product['quantity'] = $remaining;
        $product['status'] = $remaining > 0 ? 'active' : 'sold_out';

        return $product;
    }

    public static function seedDefaults(): void
    {
        $anaya = User::findByEmail('anaya.farmer@example.com');
        $ravi = User::findByEmail('ravi.farmer@example.com');

        if (! $anaya || ! $ravi) {
            return;
        }

        $products = [
            [
                'farmer' => $anaya,
                'crop_name' => 'Wheat',
                'region' => 'Punjab',
                'quantity' => 72,
                'unit' => 'quintal',
                'price' => 2390,
                'description' => 'Clean graded wheat ready for pickup.',
            ],
            [
                'farmer' => $anaya,
                'crop_name' => 'Mustard',
                'region' => 'Haryana',
                'quantity' => 28,
                'unit' => 'quintal',
                'price' => 5460,
                'description' => 'Fresh lot with low moisture.',
            ],
            [
                'farmer' => $ravi,
                'crop_name' => 'Onion',
                'region' => 'Maharashtra',
                'quantity' => 45,
                'unit' => 'quintal',
                'price' => 2165,
                'description' => 'Nashik red onion, sorted medium size.',
            ],
            [
                'farmer' => $ravi,
                'crop_name' => 'Soybean',
                'region' => 'Madhya Pradesh',
                'quantity' => 36,
                'unit' => 'quintal',
                'price' => 4580,
                'description' => 'Good quality soybean from latest harvest.',
            ],
        ];

        $mongo = app(MongoService::class);

        foreach ($products as $product) {
            $farmer = $product['farmer'];
            unset($product['farmer']);

            $mongo->upsertDocument(self::COLLECTION, [
                'farmer_id' => $farmer['_id'],
                'crop_name' => $product['crop_name'],
            ], [
                ...$product,
                'farmer_id' => $farmer['_id'],
                'farmer_name' => $farmer['name'],
                'status' => 'active',
            ]);
        }
    }
}
