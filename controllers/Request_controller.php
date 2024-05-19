<?php

    class Request_controller{
        private $req_obj;

        function __construct(){
            $this->req_obj = new Request();   
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
        }

        function update_request($array, $col, $key){
            $array = json_encode($array);


            $string = $col. " = '$array'";
            $this->req_obj->update($string, $key);
                
        }
    }

?>