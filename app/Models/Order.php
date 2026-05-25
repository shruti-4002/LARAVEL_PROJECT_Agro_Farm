<?php

namespace App\Models;

use App\Services\MongoService;
use RuntimeException;

class Order
{
    public const COLLECTION = 'orders';

    public static function place(string $productId, array $buyer, float $quantity): string
    {
        $product = Product::find($productId);

        if (! $product || ($product['status'] ?? null) !== 'active') {
            throw new RuntimeException('This crop is no longer available.');
        }

        if ($quantity <= 0) {
            throw new RuntimeException('Quantity should be greater than zero.');
        }

        if ($product['farmer_id'] === $buyer['_id']) {
            throw new RuntimeException('You cannot order your own crop.');
        }

        if ($quantity > (float) $product['quantity']) {
            throw new RuntimeException('Requested quantity is more than available stock.');
        }

        $total = round($quantity * (float) $product['price'], 2);

        $orderId = app(MongoService::class)->insertOne(self::COLLECTION, [
            'product_id' => $product['_id'],
            'seller_id' => $product['farmer_id'],
            'seller_name' => $product['farmer_name'],
            'buyer_id' => $buyer['_id'],
            'buyer_name' => $buyer['name'],
            'buyer_role' => $buyer['role'],
            'crop_name' => $product['crop_name'],
            'region' => $product['region'],
            'quantity' => $quantity,
            'unit' => $product['unit'],
            'unit_price' => (float) $product['price'],
            'total_amount' => $total,
            'status' => 'placed',
        ]);

        Product::decrementQuantity($productId, $quantity);

        return $orderId;
    }

    public static function forSeller(string $sellerId): array
    {
        return app(MongoService::class)->find(self::COLLECTION, ['seller_id' => $sellerId], [
            'sort' => ['created_at' => -1],
        ]);
    }

    public static function forBuyer(string $buyerId): array
    {
        return app(MongoService::class)->find(self::COLLECTION, ['buyer_id' => $buyerId], [
            'sort' => ['created_at' => -1],
        ]);
    }

    public static function salesSummary(string $sellerId): array
    {
        $orders = self::forSeller($sellerId);
        $byCrop = [];
        $totalSales = 0.0;
        $unitsSold = 0.0;

        foreach ($orders as $order) {
            $totalSales += (float) $order['total_amount'];
            $unitsSold += (float) $order['quantity'];

            $crop = $order['crop_name'];
            $byCrop[$crop] ??= [
                'crop' => $crop,
                'revenue' => 0.0,
                'quantity' => 0.0,
            ];
            $byCrop[$crop]['revenue'] += (float) $order['total_amount'];
            $byCrop[$crop]['quantity'] += (float) $order['quantity'];
        }

        usort($byCrop, fn ($a, $b) => $b['revenue'] <=> $a['revenue']);

        return [
            'total_sales' => $totalSales,
            'order_count' => count($orders),
            'units_sold' => $unitsSold,
            'by_crop' => array_values($byCrop),
        ];
    }
}
