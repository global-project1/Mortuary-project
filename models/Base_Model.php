<?php

    class Base_model{
        function send_mail($email, $title, $message){
            try{
                $mail = require $_SESSION['root_dir'] . '/models/mailer.php';
                         
                $mail->addAddress($email);
                
                $mail->Subject = $title;
                $mail->Body = "$message";
               
                if(! $mail->send()){
                    return false;
                }
                
                return true;

            }catch(Exception $e){
               return true;
            }
        }
    }

?>