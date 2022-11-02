<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        if (session()->get('userSessionId')){
            
            alert(__('Вы зарегестрированы'));

            return redirect()->route('user');

        }
        else {

           return view('register.index'); 
        }
            
    }
    public function store(Request $request)
    {
        // $data=$request->all();
        $name=$request->input('name');
        $email=$request->input('email');
        $password=$request->input('password');
        $password_confirmation=$request->input('password_confirmation');
        $agreement= $request->boolean('agreement');

        if ($password==$password_confirmation and $name and $email and $password){
            
        
        DB::insert('insert into users (name, email, password) values (?, ?, ?)', [$name, $email, $password]);
            $trueUser = DB::select('select * from users where email = ?', [$email]);
            $trueUser = json_decode(json_encode($trueUser), true);
            $trueUser=$trueUser['0'];
            $session = app()->make('session');
            $session->put('userSessionId', $trueUser['id']);
            


        alert(__('Добро пожаловать'));
        return redirect()->route('user');
        }
        else{
            alert(__('Не все данные введены'));
            return redirect()->back();
        }
        // $data=$request->only(['name', 'email']);
        // $data=$request->except(['name', 'email']);
         // $agreement= !! $request->input('agreement');
        
        // $avatar= $request->file('avatar');

        // $request->has('name');
        // dd($request->filled('name'));
        // dd($request->missing('name'));
        

        // dd($name, $email, $password, $password_confirmation, $agreement);

        // return 'Запрос на вход в страницу регистрации';

        // if (true) {
        //     return redirect()->back()->withInput();
        // }

        // return redirect()->route('user');
    }
    
}