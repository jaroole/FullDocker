<?php

namespace App\Exceptions;

use App\Telegram\Telegram;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Facades\Route;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

    protected $telegram;

     public function __construct(Container $container, Telegram $telegram)
     {
        parent::__construct($container);
        $this->telegram = $telegram;

     }
    

    public function report(Throwable $e)
    {
        $message = $e ->getMessage();
       
        
        $this->telegram->sendMessage(env('TELEGRAM_ID'), $message);
    }

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
