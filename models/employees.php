<?php

    class Employees{ 
        private $conn, $tableName = "employees";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
            
        }

        function add_employee(){
            $existingUsers = $this->conn->query("SELECT COUNT(*) as count FROM employees")->fetchArray(SQLITE3_ASSOC)['count'];
        
            if($existingUsers > 0){
                return "Users already exist in the database";
            }
            $sql = "INSERT INTO employees(employee_id, email, password, name)
            VALUES('01PROJECT2015', 'blaise@gmail.com', 'first@123.com', 'Abia Blaise')";

            $results = $this->conn->exec($sql);
            return $results;    
        }
        
        function sel_employee(){
            $email = $_POST['email'];
            $matricule  = $_POST['matricule'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM employees WHERE email = '$email'";
            $query = $this->conn->exec($sql);

            if(!$query){
                return [False, $this->conn->errno];  
            }

            $sql = $query->fetchArray(SQLITE3_ASSOC);   

            if(password_verify($matricule, $sql['matricule'])){

                $otp = rand(100000, 999999);
                $otpExpire = date("Y-m-d H:i:s", strtotime("+3 minute"));
                $title = "Enter your OTP for login";
                $message = "Your  OTP is:$otp";
                
                // unset($sql['password']);
                // $_SESSION['userInfo'] = $sql;

                return True;
            }

            if(password_verify($matricule, $sql['matricule'])){
                // Check if an OTP already exists for the user
                $existingOTP = $this->conn->query("SELECT otp, otp_expire FROM employees WHERE email = '$email'")->fetchArray(SQLITE3_ASSOC);
            
                if($existingOTP && strtotime($existingOTP['otp_expire']) > time()){
                    // If an OTP exists and is still valid, use the existing OTP
                    $otp = $existingOTP['otp'];
                } else {
                    // Generate a new OTP and set its expiry time
                    $otp = rand(100000, 999999);
                    $otpExpire = date("Y-m-d H:i:s", strtotime("+3 minutes"));
            
                    // Update the OTP and expiry time in the database
                    $updateSql = "UPDATE employees SET otp = '$otp', otp_expire = '$otpExpire' WHERE email = '$email'";
                    $this->conn->exec($updateSql);
                }
            
                $title = "Enter your OTP for login";
                $message = "Your OTP is: $otp";
            
                
                
                // unset($sql['password']);
                // $_SESSION['userInfo'] = $sql;
            
                return True;
            }

            return False;  
        }
    }

    $employee = new employees;
    $addEmployee = $employee->add_employee();
?>