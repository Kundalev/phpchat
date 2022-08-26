<?php


namespace App\Services;
use Ratchet\Server\IoServer;


class Router
{
    private static $list = [];

    public static function page($uri, $page_name){
        self::$list[] = [
          'uri' => $uri,
          'page' => $page_name
        ];
    }

    public static function post($uri, $class, $method, $formdata)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata,
        ];
    }

    public static function enable(){
        $query = $_GET['q'];

        foreach (self::$list as $route){
            if ($route['uri'] === '/' . $query){
                if ($route['post'] === true && $_SERVER["REQUEST_METHOD"] === 'POST') {
                    $action = new $route['class'];
                    $method = $route['method'];
                    $action->$method($_POST);
                    die();
                }else {
                    require_once 'pages/' . $route['page'] . '.php';
                    die();
                }
            }
        }
        die('404 - page not found');
    }
    public static function redirect($page){
        header('Location:' . $page);
    }
}