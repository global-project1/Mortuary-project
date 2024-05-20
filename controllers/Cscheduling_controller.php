<?php
    class Cscheduling_controller{
        private $cs_obj;

        function __construct(){
            $this->cs_obj = new corpseScheduling();
        }
        
        private function check_date(){
            // ensure that the date is not behind schedule and day is not sunday
            $exp_time = strtotime($_POST['DOR']);
            $expiry_date = new DateTime($_POST['DOR']);
            $expiry_day = date_format($expiry_date, "l");

            if($expiry_day === "Sunday"){
                return [false, "No work on Sundays"];
            }
            if($exp_time < time()){
                return [false, "Date is behind schedule"];
            }
            return [true, ''];
        }

        function corpse(){
            [$isvalid, $msg] = $this->check_date();

            if(! $isvalid){
                $_SESSION['req_error'] = $msg;
                return false;
            }
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
    }
?>