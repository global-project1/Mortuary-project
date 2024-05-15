<?php

    class Employee{
        private $conn, $tableName = "Employees";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }
         
    }


?>