<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/bot*',
	'bot*',
	'5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0',
	'laraveltesting.ru/bot',
	'laraveltesting.ru/bot*'
    ];
}
