<?php

    session_start();

    $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
    array_pop($dir);

    $root = implode('/',$dir);
    $_SESSION['root_dir'] = $root;

    $request_method = $_SERVER['REQUEST_METHOD'];
    
    include_once $root . '/config/custom_autoload.php';

    $route = explode('/', $_SERVER['REQUEST_URI'])[1];

    if($request_method == 'GET' && strpos($route, '?')){
        $route = explode('?', $route)[0];
    }

    switch (true){
        case in_array($route, ['login', 'signin']):
            if(isset($_POST)){
                $userObj = new User_controller();
                // $userObj->signIn();
            }
            break;
        
        case in_array($route, ['register', 'signup', 'registration']):
            if(isset($_POST)){
                $userObj = new User_controller();
                // $userObj->register();   
                // $userObj->insertUser();
            }
            break;
        
        default:
            require_once $root . '/views/index.php';
            break;
    }


?>