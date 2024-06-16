<?php
    class Emp_controller{
        private $emp_obj, $login;

        function __construct(){
            $this->emp_obj = new Employees();
        }
        
        function sel_employee(){
            return $this->emp_obj->read_one();   
        }
    }
?>