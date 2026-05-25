<?php

namespace App\Services;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\Exception as MongoException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use RuntimeException;
use stdClass;

class MongoService
{
    private Manager $manager;

    private string $database;

    public function __construct()
    {
        $uri = (string) config('database.connections.mongodb.dsn');
        $database = (string) config('database.connections.mongodb.database');

        if (trim($uri) === '') {
            throw new RuntimeException('Set MONGODB_URI in your .env file before using MongoDB features.');
        }

        if (trim($database) === '') {
            throw new RuntimeException('Set MONGODB_DATABASE in your .env file before using MongoDB features.');
        }

        $this->manager = new Manager($uri);
        $this->database = $database;
    }

    public function find(string $collection, array $filter = [], array $options = []): array
    {
        try {
            $query = new Query($this->prepareFilter($filter), $options);
            $cursor = $this->manager->executeQuery($this->namespace($collection), $query);

            return array_map(fn ($document) => $this->normalize($document), $cursor->toArray());
        } catch (MongoException $exception) {
            throw new RuntimeException($exception->getMessage(), previous: $exception);
        }
    }

    public function findOne(string $collection, array $filter = [], array $options = []): ?array
    {
        $options['limit'] = 1;
        $results = $this->find($collection, $filter, $options);

        return $results[0] ?? null;
    }

    public function insertOne(string $collection, array $document): string
    {
        $document['_id'] ??= new ObjectId();
        $document['created_at'] ??= now()->toDateTimeString();
        $document['updated_at'] ??= now()->toDateTimeString();

        try {
            $bulk = new BulkWrite();
            $bulk->insert($document);
            $this->manager->executeBulkWrite($this->namespace($collection), $bulk);

            return (string) $document['_id'];
        } catch (MongoException $exception) {
            throw new RuntimeException($exception->getMessage(), previous: $exception);
        }
    }

    public function updateOne(string $collection, array $filter, array $update, bool $upsert = false): void
    {
        try {
            $bulk = new BulkWrite();
            $bulk->update($this->prepareFilter($filter), $update, [
                'multi' => false,
                'upsert' => $upsert,
            ]);
            $this->manager->executeBulkWrite($this->namespace($collection), $bulk);
        } catch (MongoException $exception) {
            throw new RuntimeException($exception->getMessage(), previous: $exception);
        }
    }

    public function upsertDocument(string $collection, array $filter, array $document): void
    {
        $document['updated_at'] = now()->toDateTimeString();

        $this->updateOne($collection, $filter, [
            '$set' => $document,
            '$setOnInsert' => ['created_at' => now()->toDateTimeString()],
        ], true);
    }

    public function deleteOne(string $collection, array $filter): void
    {
        try {
            $bulk = new BulkWrite();
            $bulk->delete($this->prepareFilter($filter), ['limit' => 1]);
            $this->manager->executeBulkWrite($this->namespace($collection), $bulk);
        } catch (MongoException $exception) {
            throw new RuntimeException($exception->getMessage(), previous: $exception);
        }
    }

    public function aggregate(string $collection, array $pipeline): array
    {
        try {
            $command = new Command([
                'aggregate' => $collection,
                'pipeline' => $pipeline,
                'cursor' => new stdClass(),
            ]);

            $cursor = $this->manager->executeCommand($this->database, $command);

            return array_map(fn ($document) => $this->normalize($document), $cursor->toArray());
        } catch (MongoException $exception) {
            throw new RuntimeException($exception->getMessage(), previous: $exception);
        }
    }

    private function namespace(string $collection): string
    {
        return "{$this->database}.{$collection}";
    }

    private function prepareFilter(array $filter): array
    {
        if (isset($filter['_id']) && is_string($filter['_id']) && preg_match('/^[a-f0-9]{24}$/i', $filter['_id'])) {
            $filter['_id'] = new ObjectId($filter['_id']);
        }

        return $filter;
    }

    private function normalize(mixed $value): mixed
    {
        if ($value instanceof ObjectId) {
            return (string) $value;
        }

        if ($value instanceof UTCDateTime) {
            return $value->toDateTime()->format('Y-m-d H:i:s');
        }

        if ($value instanceof stdClass) {
            $value = (array) $value;
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->normalize($item);
            }
        }

        return $value;
    }
}
