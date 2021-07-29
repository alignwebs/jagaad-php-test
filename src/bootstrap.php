<?php

require __DIR__ . '/../vendor/autoload.php';

// Read .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
