<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqProducerService
{
    protected $connection;
    protected $channel;

    public function __construct() {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
    }

    public function publish($data, $exchange, $routingKey) {
        $msg = new AMQPMessage(json_encode($data), ['content_type' => 'application/json']);
        $this->channel->exchange_declare($exchange, 'topic', false, true, false);
        $this->channel->basic_publish($msg, $exchange, $routingKey);
        echo "User data is sent to rabbitmq";
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
