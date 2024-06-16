<?php

    class Employees extends Base_model{ 
        private $conn, $table_name = "employees";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php'; 
        }

        function add_employee(){
            try{
                // extract($name);
                $key = $this->generate_key();
                $email = 'keyzglobal0313@gmail.com';
                // $pass = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO {$this->table_name}(employee_id, email, name)
                VALUES('$key', '$email', 'Milos G')";

                $results = $this->conn->exec($sql);
                
                if(!$results){
                    echo $this->conn->lastErrorMsg();
                }
                $port = $_SERVER['HTTP_HOST'];
                $title = "Enter this password while Signing in";
                $message = <<<EOF
                your matricule for login ifs: $key.
                <a href="http://$port/password">Click here </a> to create your password

                EOF;

                $msg = $this->send_mail($email, $title, $message);

                if(! $msg[0]){
                    return [false, $msg[1]];
                }
            }catch(SQLite3Exception $e){
                return false;
            }
            return true;
        }

        function read($condition = null){
            try{
                if ($condition){
                    $select = "SELECT * FROM $this->table_name $condition";
                }
    
                else{
                    $select = "SELECT * FROM $this->table_name";
                }

                $result = $this->conn->query($select);
                if(! $result){
                    return [false, "No such record found"];
                }

                $results = array();

                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    array_push($results, $row);
                }
                // Set the global variable

                if(empty($results)){
                    return [false, "no record found"];
                }
                if(! $condition){
                    $_SESSION['all_corpse'] = $results;
                }

                return [true, $results];
            }
            catch(Exception $e){
                return [false, $this->conn->lasErrorMsg()];
            }       
        }
        
        function read_one(){
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
                    return false;
                }
            }
            else{
                $sql = "SELECT * FROM employees WHERE email = '$email' AND employee_id = '$matricule'";
                $query = $this->conn->query($sql);
    
                if(!$query){
                    return [False, $this->conn->errno];     
                }
    
                $sql = $query->fetchArray(SQLITE3_ASSOC);  
    
                if(password_verify($password, $sql['password'])){
                    $otp = rand(100000, 999999);
                    $otpExpire = date("Y-m-d H:i:s", strtotime("+30 minute"));
                    $title = "Enter your OTP for login";
                    $message = "Your OTP code is: $otp";
    
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
                    return [false, 'mail sent but otp code did not save'];
                }else{
                    return [False, 'Incorrect credentials']; 
                }
            }
        }
    }
?>