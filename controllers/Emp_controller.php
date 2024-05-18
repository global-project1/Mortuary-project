<?php

    class Emp_controller{
        private $emp_obj;

        function __construct(){
            $this->emp_obj = new Employees();
        }
        
        function sel_employee(){
            // $email = $_POST['email'];
            // $matricule  = $_POST['matricule'];
            // $password = $_POST['password'];

            // $sql = "SELECT * FROM employees WHERE email = '$email'";
            // $query = $this->conn->exec($sql);

        }
    }
?>