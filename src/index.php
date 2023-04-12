<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;

function init(): void
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

/**
 * @return resource
 */
function prepare()
{
    $resource = fopen('php://stdin', 'r');
    if(!$resource) {
        exit("[error] STDIN failure.\n");
    }

    return $resource;
}

function cleanup($resource): void
{
    fclose($resource);
    print("Bye!\n");
}

function newLine(): void
{
    print("\n");
}

function askRole($resource): string
{
    $times = 0;
    while (true) {
        echo "ChatGPTの役割を入力してください。ex)翻訳者 > ";

        $input = trim(fgets($resource, 64));
        if ($input === '') {
            $times++;
            if ($times === 3) {
                exit("[error] Too many attempts");
            }
            continue;
        }

        return $input;
    }
}

function askQuestion($resource): string
{
    $times = 0;
    while (true) {
        echo "質問を入力してください。ex)'Better than do nothing'を日本語に翻訳してください。 > ";

        $input = trim(fgets($resource, 64));
        if ($input === '') {
            $times++;
            if ($times === 3) {
                exit("[error] Too many attempts");
            }
            continue;
        }

        return $input;
    }
}

function askToAi($inputRole, $question)
{
    $openAi = new OpenAi($_ENV['OPENAI_API_KEY']);
    $chat = $openAi->chat([
        'model' => $_ENV['OPENAI_API_MODEL'],
        'messages' => [
            [
                "role" => "system",
                "content" => "あなたは{$inputRole}です。",
            ],
            [
                "role" => "user",
                "content" => $question,
            ],
        ],
        'temperature' => 1.0,
        'max_tokens' => 500,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ]);

    // decode response
    $decoded = json_decode($chat);
    // INFO: デバッグ用
    // echo var_dump($decoded);

    return $decoded;
}

function showAnswer($result)
{
    print("---------- Answer ----------\n");
    // Get Content
    print($result->choices[0]->message->content . "\n");
    print("----------------------------\n");
}

// INFO: 一連の処理実行
init();
$resource = prepare();

$role = askRole($resource);
$question = askQuestion($resource);
newLine();

$result = askToAi($role, $question);
newLine();

showAnswer($result);

cleanUp($resource);
