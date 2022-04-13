<?php

use Monolog\Logger;
use Psr\Log\LogLevel;

require_once 'vendor/autoload.php';

$logger = new Logger('test');

$logger->pushHandler
(new Monolog\Handler\RotatingFileHandler('test.log', level: LogLevel::INFO));

$logger->info('test', [
    'json' => 'test',
    'json2' => 'test'
]);