<?php

    class Deceased{
        private $conn, $tableName = "Deceased";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }
    }

?>