<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MistralAiService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $openAiApiKey)
    {
        $this->client = $client;
        $this->apiKey = $openAiApiKey;
    }



    public function generateMenu(string $cuisineType, int $nbPlats): array
    {
        $prompt = "Génère un menu de restaurant de type '$cuisineType' avec $nbPlats plats, comprenant entrée, plat principal et dessert.";

        $response = $this->client->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'mistral-tiny',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un assistant culinaire.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
            ],
        ]);

        $data = $response->toArray();

        $content = $data['choices'][0]['message']['content'] ?? '';

        return explode("\n", trim($content));
    }
}
