<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

try {
    $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    echo "Connected to RabbitMQ successfully!\n";

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
}
