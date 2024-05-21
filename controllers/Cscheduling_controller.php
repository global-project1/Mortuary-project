<?php
    class Cscheduling_controller{
        private $cs_obj, $req_obj;

        function __construct(){
            $this->cs_obj = new corpseScheduling();
        }
        
        private function check_date(){
            // ensure that the date is not behind schedule and day is not sunday
            $exp_time = strtotime($_POST['date']);
            $expiry_date = new DateTime($_POST['date']);
            $expiry_day = date_format($expiry_date, "l");

            if($expiry_day === "Sunday"){
                return [false, "No work on Sundays"];
            }
            if($exp_time < time()){
                return [false, "Date is behind schedule"];
            }
            return [true, $expiry_day];
        }

        function corpse(){
            [$isvalid, $msg] = $this->check_date();

            if(! $isvalid){
                $_SESSION['req_error'] = $msg;
                return false;
            }
            $chosen = $this->check_slots($_POST['date']);
            if(empty($chosen)){
                $_SESSION['req_error'] = "Day has no empty slot";
                return false;
            }

            // check if any slot is free for the day he chose
            $schedules = $this->cs_obj->corpse();

            if ($schedules[0]){
                // Set the corpse remover information
                $_SESSION['corpse_remover'] = $_POST;
                return true;

            }else{
                $_SESSION['req_error'] = $schedules[1];
                return false;
            }
        }

        function check_slots($date){
            // set the slots
            $date_obj = new DateTime($date);
            $week_number = date_format($date_obj, "W");
            $day = date_format($date_obj, "l");

            $req_obj = new Request_controller();

            $result = $req_obj->get_request($day);

            $chosen = array();
            echo '<pre>';
            foreach($result as $slot => $res){
                $arr = json_decode($res);
                $dur = $arr[0]->duration;
                $tester = false;

                foreach($arr as $r){
                    if($r->week_number != $week_number){
                        $tester = true;
                    }
                }
                if($tester){
                    array_push($chosen, [$slot, $dur]);
                }
            }
            
            return $chosen;
        }

        function manage_otp(){

            extract($_SESSION['corpse_remover']);

            $dec_obj = new Deceased_controller();
            $otp = $_POST['otp'];

            $cond = "WHERE otp = $otp AND guardian_email = '$email'";
            [$stats, $results] = $dec_obj->get_corpse($cond);

            if(! $stats){
                // redirect the person to choose a slot
                $_SESSION['req_error'] = $results;
                header("Location: /request");
                exit;
            }
            
            $chosen = $this->check_slots($date);

            $_SESSION['free_slots'] = $chosen;
            
            header("Location: /slot");
            exit();
        }
    }
?>