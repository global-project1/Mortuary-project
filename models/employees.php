<?php
        use PHPMailerPHPMailerException;

    class employees{
        
        private $conn, $tableName = "employees";


        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
            require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/phpmailer.php';
            require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/SMTP.php';
            require_once $_SESSION['root_dir'] . '/vendor/phpmailer/phpmail/Exception.php';
        }

        function add_employee(){

            $existingUsers = $this->conn->query("SELECT COUNT(*) as count FROM employees")->fetchArray(SQLITE3_ASSOC)['count'];
        
            if($existingUsers > 0){
                return "Users already exist in the database";
            }
            $sql = "INSERT INTO employees(employee_id, email, password, name)
            VALUES('01PROJECT2015', 'blaise@gmail.com', 'first@123.com', 'Abia Blaise'),
            ('02PROJECT2015', 'axel@gmail.com', 'second@123.com1', 'Axel Thiery'),
            ('03PROJECT2015', 'stephan@gmail.com', 'third@123.com30', 'Awoulbe Stephan'),
            ('04PROJECT2015', 'broashu@gmail.com', 'fourth@123.com80', 'Brother Ashu Oscar'),
            ('05PROJECT2015', 'joyce@gmail.com', 'fifth@123.com100', 'Joyce Pascalina'),
            ('05PROJECT2015', 'milton@gmail.com', 'sixth@123.com20', 'Milton'),
            ('06PROJECT2015', 'caleb@gmail.com', 'seventh@23.com80', 'Caleb'),
            ('07PROJECT2015', 'nolan@gmail.com', 'eight@123.com50', 'Nolan')";

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

                $mail = new PHPMailerPHPMailerPHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your@example.com';
                $mail->Password = 'your_password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('your@example.com', 'Your Name');
                
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
            
                $mail = new (true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your@example.com';
                $mail->Password = 'your_password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('your@example.com', 'Your Name');
                
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