<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

index();

function index(): void
{
    echo var_dump('index');
}
