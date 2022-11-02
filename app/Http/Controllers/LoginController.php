<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function index(Request $request)
    {

        
            if (session()->get('userSessionId')){
                
                alert(__('Вы авторизованы'));
    
                return redirect()->route('user');
    
            }
            else {
    
              return view('login.index');  
            }
               
        
        
        // return app('view')->make('login.index');
        // return view()->make('login.index');
        // return View::make('login.index');

        // $ip=$request->ip();
        // $path=$request->path();
        // $url=$request->url();
        // $fullurl=$request->fullurl();


        // dd($ip, $path, $url, $fullurl);
        // session()->put('foo','bar');
        // session()->flush(); 
        // session()->forget('foo');     
        // dd(session()->has('foo'));
        // dd(session()->all());

        
        
    }
    public function store(Request $request)
    {

        //session(['alert'=>__('Добро пожаловать')]);
        $email=$request->input('email');
        $password=$request->input('password');
      
      if ($trueUser = DB::select('select * from users where email = ?', [$email])){
        $trueUser = json_decode(json_encode($trueUser), true);
        $trueUser=$trueUser['0'];
        $activeUser=$trueUser['active'];

        // dd($trueUser);
        if ($activeUser==1 and $password==$trueUser['password']){
            
        
            $session = app()->make('session');
            $session->put('userSessionId', $trueUser['id']);
            $userSessionId=$session->get('userSessionId');
            // $sessionId=$session['drivers'];
            // dd($sessionId);

            //dd($userSessionId);
            $session = Session::put(DB::select('select * from users where email = ?', [$email]));
            
            alert(__('Добро пожаловать'));
            return redirect()->route('user');
           
           
            }
        else {
            alert(__('Введенные данные неверны'));
            return redirect()->back();

        }}
        else{

            alert(__('Нет пользователя'));
            return redirect()->back();
        }
       
      

        // $session = app()->make('session');
        // $session = app('session');
        // $session = Session::get('key');
        // $session = Session::put('key');
        // session()->put('foo','bar');


        
        
        
        
        // $ip=$request->ip();
        // $path=$request->path();
        // $url=$request->url();


        // dd($ip, $path, $url);

        // $email=$request->input('email');
        // $password=$request->input('password');
        // $remember= $request->boolean('remember');

        // dd($email, $password, $remember);
        
        
        // return 'Запрос на вход';

    // return response()->redirectToRoute('user');
    // return redirect()->route('user');
    // if (true) {
    //     return redirect()->back()->withInput();
    // }

   

    }
    
}
