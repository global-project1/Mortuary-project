<?php

    session_start();

    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        return true; // Suppress the warning
    });

    $dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($dir);
    $root = implode('/',$dir);
    $_SESSION['root_dir'] = $root;

    include_once $root . '/config/custom_autoloader.php';

    $request_method = $_SERVER['REQUEST_METHOD'];
    $route = explode('/', $_SERVER['REQUEST_URI'])[1];

    $base = new Base_controller();

    //Enable get requests via the url 
    if($request_method == 'GET' && strpos($route, '?')){
        $route = explode('?', $route)[0];
    }

    if($_SERVER['REQUEST_URI'] === '/' || $route === ""){
        $base->home($page = "index");
    }

    switch (true){
        case in_array($route, ['login', 'signin']):
            if($request_method == 'POST'){
                $base->signIn(); 
            }
            else{
                $base->home($page = "login");
            }
            break;
            
        case in_array($route, ['dashboard', 'home']):
            $dash_obj = new Dashboard_controller();

            if($request_method == "POST"){
                $dash_obj->examine_post();
            }else{
                $dash_obj->index();
            }
            break;
        
        case $route === 'logout':
            $base->logout();
            break;

        case in_array($route, ['otp']):
            if($request_method == 'POST'){
                $base->otp();
            }else{
                $base->home($page = "otp");
            }
            break;
            
        case in_array($route, ['slot', 'booking']):
            if($request_method == 'POST'){
                $base->slot();
            }else{
                $base->home($page = "slot");
            }
            break;

        case in_array($route, ['request', 'corpse']):
            if($request_method == 'POST'){
                $base->schedule();
            }else{
                $base->home($page = "request");
            }
            break;

        case $route == 'password':
            if($request_method == 'POST'){
                $base->pass();
            }else{
                $base->home($page = "password");
            }
            break;

        default:
            $base->home($page = "index");
            break;

    }   

?>