<?php
    class corpseScheduling extends Base_model{
        private $conn;

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php'; 
        }

        function corpse(){
            extract($_POST);

            $sql = "SELECT id FROM deceased WHERE id= ? AND guardian_email = ?";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(1, $corpseId);
            $stmt->bindValue(2, $email);

            $result = $stmt->execute();

            if(! $result){
                return [False, $this->conn->errno];
            }
            $sql = $result->fetchArray(SQLITE3_ASSOC);

            if(! empty($sql)){

                $otp = rand(100000, 999999);
                $otpExpire = strtotime(date("Y-m-d H:i:s", strtotime("+60 minute")));
                
                $title = "Enter your OTP for corpse verification";
                $message = "Enter the following code to confirm it is you <br> <h3> $otp </h3> The code expires after an hour";
    
                $msg = $this->send_mail($email, $title, $message);
    
                if(! $msg[0]){ 
                    return [false, $msg[1]];
                }

                $sql = "UPDATE deceased SET otp = $otp, otp_expire = $otpExpire WHERE id = '$corpseId'";
                $result = $this->conn->exec($sql);

                if($result){
                    return [true, "otp successfully saved and sent"];
                }
                return [false, "mail sent but otp did not save"];
            }
            else{
                return [false, "not found"];
            } 
        } 
    }
?>