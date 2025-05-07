<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RabbitmqProducerService;

class RabbitmqProducerController extends Controller
{
    protected $rabbitmqProducerService;

    public function __construct()
    {
        $this->rabbitmqProducerService = new RabbitmqProducerService();
    }

    public function publish(){

        $user = [
            'name' => 'Salauddin Shanto',
            'email' => 'salauddin.innovx@gmail.com',
        ];

        // $orderData = [
        //     'name' => 'Headphone',
        //     'amount' => '10'
        // ];
        $this->rabbitmqProducerService->publish($user, 'order_exchange' , 'order.create');
    }
}
