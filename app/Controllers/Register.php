<?php

namespace App\Controllers;
use App\Controllers\Database;

class Register
{
    public function register($data){
        $names = [];
        $items = Database::getAll("SELECT * FROM `users`");
        foreach ($items as $item){
            $names [] = $item['name'];
        }
        if (!in_array($data['name'], $names)){
            $insert_id = Database::add("INSERT INTO `users` SET `name` = ?", $data['name']);
            $key = 'strongkey';
            $method = "AES-192-CBC";
            $encrypted = openssl_encrypt($data['name'], $method, $key);
            echo json_encode([
                'name' => $data['name'],
                'token' => $encrypted,
                'color' => $data['color']
            ]);
        }else{
            echo 'This name is already taken';
        }
    }
}