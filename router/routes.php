<?php


use App\Controllers\Register;
use App\Controllers\GetUsers;
use App\Services\Router;

Router::page('/', 'home');

Router::post('/register', Register::class, 'register', 'true');
Router::post('/getUsers', GetUsers::class, 'get', 'true');

Router::enable();