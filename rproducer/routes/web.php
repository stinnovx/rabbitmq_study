<?php

use App\Events\MailTestEvent;
use App\Http\Controllers\RabbitmqProducerController;
use App\Jobs\SendEmailJobRabbitmq;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mail', function(){
    $user['name'] = 'Salauddin Shanto';
    $user['email'] = 'salauddin.innovx@gmail.com';
    Mail::to($user['email'])->send(new TestMail($user));
});


Route::get('/event-listener', function () {
    $user = new User();
    $user['name'] = 'Salauddin Shanto';
    $user['email'] = 'salauddin.innovx@gmail.com';
    event(new MailTestEvent($user));
});

// Route::get('/rabbitmq', function () {
//     $user = new User();
//     $user['name'] = 'Salauddin Shanto';
//     $user['email'] = 'salauddin.innovx@gmail.com';
// });

Route::get('/rabbitmq', [RabbitmqProducerController::class, 'publish']);
