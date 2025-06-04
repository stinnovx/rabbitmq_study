<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use App\Services\RabbitmqConsumerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            $user = json_decode($msg->body);
            Log::info('Mail sent to: '. json_encode($user));
            Mail::to($user->email)->send(new TestMail($user));
        });
    }
}
