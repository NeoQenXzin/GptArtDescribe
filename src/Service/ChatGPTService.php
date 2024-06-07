<?php

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ChatGPTService
{
    private $client;
    private $apiKey;

    public function __construct(ParameterBagInterface $params)
    {
        $this->client = new Client();
        $this->apiKey = $params->get('chatgpt.api_key');
    }

    public function generateImageDescription(string $imageUrl): string
    {
        
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an image description generator.',
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Generate a description for this image: ' . $imageUrl,
                    ],
                ],
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['choices'][0]['message']['content'] ?? 'No description available';
    }
}