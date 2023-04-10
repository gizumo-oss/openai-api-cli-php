<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;

function init(): void
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

function index(): void
{
    $openAi = new OpenAi($_ENV['OPENAI_API_KEY']);
    $chat = $openAi->chat([
        'model' => $_ENV['OPENAI_API_MODEL'],
        'messages' => [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => "Who won the world series in 2020?"
            ],
            [
                "role" => "assistant",
                "content" => "The Los Angeles Dodgers won the World Series in 2020."
            ],
            [
                "role" => "user",
                "content" => "Where was it played?"
            ],
        ],
        'temperature' => 1.0,
        'max_tokens' => 500,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ]);

    // decode response
    $decoded = json_decode($chat);
    echo var_dump($decoded);

    echo "\n\n";

    echo print("----- Result -----\n");
    // Get Content
    echo($decoded->choices[0]->message->content);
}

init();
index();
