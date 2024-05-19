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

            echo '<pre>';
            foreach($data as $dt){
                foreach($dt as $d => $value){
                    echo $d . '<br>';
                }
                die;
            }

            die;
        }

        function update_request($array, $col, $key){
            $array = json_encode($array);

            $string = $col. " = '$array'";
            $this->req_obj->update($string, $key);
                
        }
    }

?>