<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/users', function (Request $request) {
    return [
        'data' => [
            [
                'id' => 1,
                'name' => 'guilherme Santos',
                'email' => 'szguisantos@gmail.com',
                'password' => 'password',
                'isadmin' => true,
            ],
            [
                'id' => 2,
                'name' => 'Grasiele P P Santos',
                'email' => 'szgra@gmail.com',
                'password' => 'password',
                'isadmin' => false,
            ]
        ]
    ];
});
