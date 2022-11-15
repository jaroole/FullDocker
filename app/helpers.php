<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// if (!function_exists('test')){
//     function test()
//     {
//         return app('test');
//     }
// }



if (!function_exists('active_link')){
    function active_link(string $name, $active='active' ):string
    {
        return Route::is($name) ? $active : '';
    }
}

if (!function_exists('alert')){
    function alert(string $value)
    {
        session(['alert'=>$value]);
    }
}



