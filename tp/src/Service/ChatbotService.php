<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatbotService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $openaiApiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $openaiApiKey;
    }

    public function getResponse(string $userMessage): string
    {
        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant for a restaurant.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ],
        ]);

        dd($response);
        $data = $response->toArray();
        return $data['choices'][0]['message']['content'] ?? 'Je suis désolé, je n’ai pas compris votre question.';
    }
}
