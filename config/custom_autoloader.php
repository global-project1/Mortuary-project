<?php

    spl_autoload_register('myautoloader');

    function myautoloader($className){
        $dirs = ['/models/', '/controllers/','vendor/phpmailer/phpmailer/src'];

        foreach($dirs as $dir){
            $file = $_SESSION['root_dir']. $dir . $className .'.php';

            if(file_exists($file)){
                require_once $file;
            }
        }
    }
?>