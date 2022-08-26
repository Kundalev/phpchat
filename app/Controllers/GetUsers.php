<?php

namespace App\Controllers;

class GetUsers
{
    public function get(){
        $users = Database::getAll("SELECT * FROM `users`");
        echo(json_encode($users));
    }
}