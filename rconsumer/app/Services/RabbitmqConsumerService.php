<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqConsumerService
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
    }

    public function consume($queue, $exchange, $routingKey, $callback){

        $this->channel->exchange_declare($exchange, 'topic', false, true, false);
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->channel->queue_bind($queue, $exchange, $routingKey);

        $this->channel->basic_consume($queue, '', false, true, false, false, $callback);
        Log::info('this is consumer');
        while($this->channel->callbacks){

            try{
                $this->channel->wait(null, false, 10);
                Log::info('after wait');
            }
            catch(\PhpAmqpLib\Exception\AMQPTimeoutException $e){
                Log::info('No message receiving. Continue...');
                continue;
            }
            catch(Exception $e){
                Log::error('Consumer error: ' . $e->getMessage());
                break;
            }
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
