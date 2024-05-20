<?php
    class Cscheduling_controller{
        private $cs_obj, $schedule;

        function __construct(){
            $this->cs_obj = new corpseScheduling();
        }
        
        function corpse(){
            $schedule = new corpseScheduling;
            $schedules = $schedule->corpse();

            if ($schedules){
                return true;
            }else{
                return false;
            }
            die;
        }
    }
?>