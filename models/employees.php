<?php

    class Employees extends Base_model{ 
        private $conn, $table_name = "employees";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php'; 
        }

        function add_employee(){
            try{
                $sql = "INSERT INTO {$this->table_name}(employee_id, email, password, name)
                VALUES('01PRO2015', 'afegenuim@gmail.com', 'school@.com1', 'Milos Gs')";
    
                $results = $this->conn->exec($sql);
                return true;    

            }catch(SQLite3Exception $e){
                return false;
            }
        }
        
        function sel_employee(){
            extract($_POST);

            $sql = "SELECT * FROM employees WHERE email = '$email'";
            $query = $this->conn->query($sql);

            if(!$query){
                return [False, $this->conn->errno];  
            }

            $sql = $query->fetchArray(SQLITE3_ASSOC);   

            if(password_verify($password, $sql['password'])){
                $otp = rand(100000, 999999);
                $otpExpire = date("Y-m-d H:i:s", strtotime("+30 minute"));
                $title = "Enter your OTP for login";
                $message = "Your  OTP is:$otp";

                $this->send_mail($email, $title, $message);

                return [True, 'success'];
            }

            return [False, 'login failed'];  
        }

    }

?>