<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiAdvisor
{
    public function ask(string $message, array $farmer, array $marketRows, array $products): string
    {
        // FIX 1: config('services.openai.api_key') kiya taaki config/services.php se match ho sake
        $apiKey = (string) config('services.openai.api_key');
        $baseUrl = rtrim((string) config('services.openai.base_url', 'https://api.openai.com/v1'), '/');

        if (trim($apiKey) === '') {
            return 'OpenAI key abhi set nahi hai. .env me OPENAI_API_KEY add kar do, phir farmer chat live ho jayega.';
        }

        $context = [
            'farmer' => [
                'name' => $farmer['name'],
                'region' => $farmer['region'] ?? 'Unknown',
            ],
            'local_mandi_prices' => array_slice($marketRows, 0, 12),
            'my_products' => array_map(fn ($product) => [
                'crop' => $product['crop_name'],
                'region' => $product['region'],
                'quantity' => $product['quantity'],
                'unit' => $product['unit'],
                'price' => $product['price'],
            ], array_slice($products, 0, 8)),
        ];

        // System Instruction Content String Builder
        $instructions = implode("\n", [
            'You are an Indian agriculture market advisor for farmers.',
            'Reply in clear Hinglish when the user writes Hinglish.',
            'Use the provided mandi prices and product context to suggest practical pricing, selling, and inventory actions.',
            'Keep advice concise and mention uncertainty when data is only indicative.',
        ]);

        // FIX 2: Gemini Proxy/OpenAI standard endpoint route '/chat/completions' use kiya aur payload modify kiya
        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(45)
            ->post($baseUrl . '/chat/completions', [
                'model' => config('services.openai.model', 'gemini-2.5-flash'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $instructions
                    ],
                    [
                        'role' => 'user',
                        'content' => "Context:\n".json_encode($context, JSON_PRETTY_PRINT)."\n\nFarmer question:\n{$message}"
                    ]
                ]
            ]);

        if ($response->failed()) {
            throw new RuntimeException('OpenAI request failed: '.$response->body());
        }

        return $this->extractText($response->json()) ?: 'AI ne empty response diya. Please dobara try karo.';
    }

    private function extractText(array $payload): string
    {
        // Gemini aur OpenAI standard JSON schema extractor loop
        if (isset($payload['choices'][0]['message']['content'])) {
            return trim($payload['choices'][0]['message']['content']);
        }

        if (isset($payload['output_text']) && is_string($payload['output_text'])) {
            return trim($payload['output_text']);
        }

        $parts = [];
        foreach (($payload['output'] ?? []) as $output) {
            foreach (($output['content'] ?? []) as $content) {
                if (isset($content['text'])) {
                    $parts[] = $content['text'];
                }
            }
        }

        return trim(implode("\n", $parts));
    }
}