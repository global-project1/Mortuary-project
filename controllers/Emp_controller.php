<?php
    class Emp_controller{
        private $emp_obj, $login;

        function __construct(){
            $this->emp_obj = new Employees();
        }
        
        function sel_employee(){
            $logins = $this->emp_obj->sel_employee();

            if($logins){         
               return true;

            }else{
                return false;
            }
            die;
        }    
    }
?>