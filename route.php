<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

if($_SERVER["REQUEST_METHOD"]=="OPTIONS") return true;


spl_autoload_register(function ($class) {
    $path = "model/" . $class . ".php";
    if (file_exists($path)) {
        require_once "$path";
    }
    //  else {
    //     $path = "config/" . $class . ".php";
    //     require_once "$path";
    // }
});

/* controller/delete/1 */

// ApiAppointement/updateAnAppointement/1

//  params [0] / params [1] / params [2]

$params = explode('/', $_GET['p']);

if (isset($params[0]) & !empty($params[0])) {

    $controller = ucfirst($params[0]);


    if (file_exists("controller/" . $controller . ".php")) {

        require_once 'controller/' . $controller . ".php";
        $obj = new $controller();
        if (isset($params[1]) & !empty($params[1])) {
            if (method_exists($obj, $params[1])) {
                $action = $params[1];
                
                if (isset($params[2]) & !empty($params[2])) {
                    $obj->$action($params[2]);
                } else {
                    $obj->$action();
                }
            } else {
                http_response_code(404);
                echo "this method doesn't exist";
            }
        } else {
            $action = "index";
            $obj->$action();
        }
    } else {
        http_response_code(404);
        echo "this page doesn't exsit";
    }
}
