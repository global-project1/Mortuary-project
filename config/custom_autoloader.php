<?php

    spl_autoload_register('myautoloader');
    require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/phpmailer.php';
    require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/SMTP.php';
    require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/Exception.php';

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