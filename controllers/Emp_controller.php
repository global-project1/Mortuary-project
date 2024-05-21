<?php
    class Emp_controller{
        private $emp_obj, $login;

        function __construct(){
            $this->emp_obj = new Employees();
        }
        
        function sel_employee(){
            $login = new Employees;
            return $login->sel_employee();
            
        }

        function updateEmployees(){
            $login = new Employees;
            $logins = $login->sel_employee();

            if($logins){
                header("location: dashboard");
            }else{
                header("location: otp");
            }
        }    
    }
?>