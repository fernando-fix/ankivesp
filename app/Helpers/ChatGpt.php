<?php

namespace App\Helpers;

use GuzzleHttp\Client;

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
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => '
                    Gerar 3 perguntas para uma transcrição de uma aula respeitando as seguintes regras:
                    Cada pergunta deve ser de carater explicativo e somente uma das alternativas deve ser a correta,
                    Variar a posição da resposta correta no json, pode ser 1, 2, 3, 4 ou 5,
                    Uma questão deve ter três afirmações para verificar se é verdadeiro ou falso nas respostas (numeração em romano),
                    Cada pergunta deve ter 5 opções de resposta,
                    Ao final das respostas deve indicar qual é a resposta correta,
                    Formular as questões sem mencionar a aula, se for necessário dar uma pequena introdução ao assunto,
                    Formatar as questões como html e css quando necessário,
                    Adicionar uma quebra de linha no final das perguntas,

                    json de exemplo:

                        {
                            "questions": [
                                {
                                    "question": "<p>pergunta gerada</p>",
                                    "answers": [
                                        {
                                            "answer": "<p>Opção de resposta 1</p>",
                                            "correct": true
                                        },
                                        {
                                            "answer": "<p>Opção de resposta 2</p>",
                                            "correct": false
                                        },
                                        {
                                            "answer": "<p>Opção de resposta 3</p>",
                                            "correct": false
                                        },
                                        {
                                            "answer": "<p>Opção de resposta 4</p>",
                                            "correct": false
                                        }
                                    ]
                                }
                            ]
                        }

                        '],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
