<?php
    class corpseScheduling extends Base_model{
        private $conn;

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php'; 
        }

        function corpse(){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $dor = $_POST['dor'];
            $corpse = $_POST['corpseId'];

            $sql = "SELECT id FROM deceased WHERE id='$corpse'";
            $query = $this->conn->query($sql);

            if(! $query){
                return [False, $this->conn->errno];
            }

            $sql = $query->fetchArray(SQLITE3_ASSOC);
            if($corpse === $sql['id']){

                $otp = rand(100000, 999999);
                $otpExpire = date("Y-m-d H:i:s", strtotime("+30 minute"));
                $title = "Enter your OTP for corpse verification";
                $message = "Your  OTP is:$otp";
    
                $msg = $this->send_mail($email, $title, $message);
    
                if(! $msg[0]){ 
                    return [false, $msg[1]];
                }

                $sql = "UPDATE deceased SET otp = $otp WHERE id = '$corpse'";
                $result = $this->conn->exec($sql);

                if($result){
                    return [true, "otp successfully saved"];
                }
                return [false, "mail sent but otp did not save"];
            }


        } 
    }
?>