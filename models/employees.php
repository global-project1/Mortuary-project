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

            if(isset($_POST['otp'])){
                $email = $_SESSION['email'];

                $sql = "SELECT * FROM employees WHERE email = ? AND otp = ?";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(1, $email);
                $stmt->bindValue(2, $otp);
                $result = $stmt->execute();

                if($result){
                    $result = $result->fetchArray(SQLITE3_ASSOC);  
                   if($result){
                        return true;
                   }

                    return false;
                }
                else{
                    false;
                }

            }

            $sql = "SELECT * FROM employees WHERE email = '$email'";
            $query = $this->conn->query($sql);

            if(!$query){
                return [False, $this->conn->errno];  
            }

            $sql = $query->fetchArray(SQLITE3_ASSOC);  

            if($password === $sql['password']){
                $otp = rand(100000, 999999);
                $otpExpire = date("Y-m-d H:i:s", strtotime("+30 minute"));
                $title = "Enter your OTP for login";
                $message = "Your  OTP is:$otp";

                $msg = $this->send_mail($email, $title, $message);

                if(! $msg[0]){ 
                    return [false, $msg[1]];
                }

                $sql = "UPDATE employees SET otp = $otp WHERE email = '$email'";
                $result = $this->conn->exec($sql);
                
                if($result){
                    $_SESSION['email'] = $email;
                    return [true, "otp successfully saved"];
                }
                return [false, 'mail sent but otp did not save'];

            }

            return [False, 'login failed'];  
        }

    }

?>