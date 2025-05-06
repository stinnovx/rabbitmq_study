<?php

namespace App\Console\Commands;

use App\Services\RabbitmqConsumerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsumeOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for order consumer';
    protected $rabbitmqConsumer;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->rabbitmqConsumer = new RabbitmqConsumerService();

        $this->rabbitmqConsumer->consume('order_queue', 'order_exchange', 'order.create', function ($msg){
            Log::info('Consumed order: '.$msg->body);
        });
    }
}
