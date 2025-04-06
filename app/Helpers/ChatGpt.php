<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use App\Models\Config;

class ChatGpt
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function chat($message)
    {
        $response = $this->client->post('chat/completions', [
            'json' => [
                // 'model' => 'gpt-4',
                'model' => 'o3-mini',
                'messages' => [
                    ['role' => 'system', 'content' => Config::getByKey('prompt_gpt')],
                    ['role' => 'user', 'content' => $message],
                ],
                // 'temperature' => 0.7,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
