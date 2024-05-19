<?php

    class Base_model{
        protected function generate_key(){
            $string = "M@RTUADY";

            $id = 1;
            $old_id = $_SESSION['root_dir']. '/models/storage/key.txt';

            if(file_exists($old_id)){
                $fp = fopen($old_id, 'r');
                $id = fgets($fp);
                $id++;
            }
            $string = $string.$id;
            $key = str_shuffle($string);
            $key = (strlen($key) > 9)? substr($key, 0, 9): $key;

            $fp = fopen($old_id, 'w');
            fwrite($fp, $id);
            fclose($fp);

            return $key;
        }

        protected function send_mail($email, $title, $message){
            try{
                $mail = require $_SESSION['root_dir'] . '/models/mailer.php';        
                $mail->addAddress($email);
                
                $mail->Subject = $title;
                $mail->Body = $message;
               
                if(! $mail->send()){
                    return [false, $mail->ErrorInfo];
                }
                return [true, "mail sent"];

            }catch(Exception $e){
               return [false, $e->getMessage()];
            }
        }
    }

?>