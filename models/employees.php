<?php

    class Employees extends Base_model{ 
        private $conn, $table_name = "employees";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php'; 
        }

        function add_employee(){
            try{
                extract($name);
                $pass = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO {$this->table_name}(employee_id, email, password, name)
                VALUES('$employee_id', '$email', '$pass', '$name')";

                $results = $this->conn->exec($sql);
                
                if(!$results){
                    echo $this->conn->lastErrorMsg();
                }

                $title = "Enter this password while Signing in";
                $message = "Your password is: $password and your matricule is:$employee_id";
                $msg = $this->send_mail($email, $title, $message);

                if(! $msg[0]){
                    return [false, $msg[1]];
                }
            }catch(SQLite3Exception $e){
                return false;
            }
            return true;
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
                    return $result->fetchArray(SQLITE3_ASSOC);  
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