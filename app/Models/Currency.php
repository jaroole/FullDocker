<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;


    public $incrementing = false;

    //protected $connection='second';
    protected $fillable = [
        'id',
        'name',
        'price',
        'active',
        'sort',
        

    ];
    
    // protected $guarded = [
    //     'secret',
    // ];


    protected $hidden = [
        // 'password',
        // 'remember_token',
        // 'price',

    ];


        protected $casts = [
            
            'price'=>'float',
            'active'=>'boolean',
            // 'secret'=>'encrypted',
            // 'password'=>'encrypted',

        ];

        protected $dates = [

            'active_at'

        ];

}
