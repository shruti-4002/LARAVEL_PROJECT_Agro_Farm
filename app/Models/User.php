<?php

namespace App\Models;

use App\Services\MongoService;
use Illuminate\Support\Facades\Hash;

class User
{
    public const COLLECTION = 'users';

    public static function create(array $attributes): array
    {
        $mongo = app(MongoService::class);

        $document = [
            'name' => trim($attributes['name']),
            'email' => strtolower(trim($attributes['email'])),
            'password' => Hash::make($attributes['password']),
            'role' => $attributes['role'],
            'region' => trim($attributes['region'] ?? ''),
        ];

        $id = $mongo->insertOne(self::COLLECTION, $document);

        return self::safe([
            ...$document,
            '_id' => $id,
        ]);
    }

    public static function find(string $id): ?array
    {
        $user = app(MongoService::class)->findOne(self::COLLECTION, ['_id' => $id]);

        return $user ? self::safe($user) : null;
    }

    public static function findByEmail(string $email): ?array
    {
        return app(MongoService::class)->findOne(self::COLLECTION, [
            'email' => strtolower(trim($email)),
        ]);
    }

    public static function safe(array $user): array
    {
        unset($user['password']);

        return $user;
    }

    public static function seedDefaults(): void
    {
        $users = [
            [
                'name' => 'Anaya Sharma',
                'email' => 'anaya.farmer@example.com',
                'password' => Hash::make('password'),
                'role' => 'farmer',
                'region' => 'Punjab',
            ],
            [
                'name' => 'Ravi Patil',
                'email' => 'ravi.farmer@example.com',
                'password' => Hash::make('password'),
                'role' => 'farmer',
                'region' => 'Maharashtra',
            ],
            [
                'name' => 'Meera Buyer',
                'email' => 'meera.buyer@example.com',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'region' => 'Delhi NCR',
            ],
        ];

        $mongo = app(MongoService::class);

        foreach ($users as $user) {
            $mongo->upsertDocument(self::COLLECTION, ['email' => $user['email']], $user);
        }
    }
}
