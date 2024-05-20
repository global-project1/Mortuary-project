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
                        if($slot->status){

                            $now = time();
                            $date = new DateTime($slot->expiry_date);   
                            $date_format = $date->format("Y-m-d"); 

                            $expiry_time = explode('-', $slot->duration)[1];
                            $expiry_time = strtotime($date_format.' '.$expiry_time);
                            
                            if($now >= $expiry_time){
                                // reset the values of the slot
                                $new_dt = array(
                                    "date_of_activation" => null,
                                    "duration" => $slot->duration,
                                    "expiry_date" => null,
                                    "status" => false
                                );

                                // update the db

                                $this->update_request($new_dt, "slot".$val+1, $day);
                            }   
                        }
                    }
                }
            }
        }

        function add_request(){

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

        function update_request($array, $col, $key){
            $array = json_encode($array);

            $string = $col. " = '$array'";
            $this->req_obj->update($string, $key);
                
        }
    }

?>