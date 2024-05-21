<?php

    class Request_controller{
        private $req_obj;

        function __construct(){
            $this->req_obj = new Request();   
            $this->clear_expired();
        }

        private function clear_expired(){
            $requests = $this->get_requests();
            foreach($requests as $request){
                foreach($request as $day => $value){
                    foreach($value as $val => $slot){
                        foreach($slot as $week_block){
                            if($week_block->status){
    
                                $now = time();
                                $date = new DateTime($week_block->expiry_date);   
                                $date_format = $date->format("Y-m-d"); 
    
                                $expiry_time = explode('-', $week_block->duration)[1];
                                $expiry_time = strtotime($date_format.' '.$expiry_time);
                                
                                if($now >= $expiry_time){
                                    // reset the values of the slot
                                    $new_dt = array([
                                        "week_number" => null,
                                        "date_of_activation" => null,
                                        "duration" => $week_block->duration,
                                        "expiry_date" => null,
                                        "status" => false
                                    ]);
                                    // update the db
                                    $this->update_request($new_dt, "slot".$val+1, $day);
                                }   
                            }
                        }                 
                    }
                }
            }
        }

        function get_requests($cond = null){
            [$status, $data] = $this->req_obj->read($cond);

            $_SESSION['requests'] = [];
            
            foreach($data as $dt){
                $new_data = array();
                foreach($dt as $d => $value){
                    if($d != 'week_day'){
                        array_push($new_data, json_decode($value));
                    }
                }
                array_push($_SESSION['requests'], array($dt['week_day'] =>$new_data));
            }
            return $_SESSION['requests'];
        }

        function get_request($value = null){
            return $this->req_obj->read_one($value);
        }

        function update_request($array = null, $col = null, $key = null){
            // $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            // for($i = 0; $i < count($days); $i++){
            //     $key = $days[$i];
            //     $new_dt = array([
            //         "week_number" => null,
            //         "date_of_activation" => null,
            //         "duration" => "15:30:00-17:00:00",
            //         "expiry_date" => null,
            //         "status" => false
            //     ]);

            // }
            $array = json_encode($array);
            $string =  $col. " = '$array'";

            $this->req_obj->update($string, $key);          
        }
    }

?>