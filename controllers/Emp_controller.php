<?php

    class Emp_controller{
        private $emp_obj, $login;

        function __construct(){
            $this->emp_obj = new Employees();
        }
        
        function sel_employee(){
            $login = new Employees;
            $logins = $login->sel_employee();

            if($logins){
                $logins  = $login->generate_key();
                header("location: otp");
            }else{
                header("location: login");
            }
        }
    }
?>