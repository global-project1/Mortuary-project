<?php

    class Request_controller{
        private $req_obj;

        function __construct(){
            $this->req_obj = new Request();   
        }

        function add_request(){

        }

        function get_request(){

        }

        function update_request(){
            $time = ['8:00:00-8:30:00', '8:30:00-9:00:00', '9:00:00-9:30:00', '9:30:00-10:00:00', '10:00:00-10:30:00', '10:30:00-11:00:00'];

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            
            foreach($days as $key){
                for ($i = 0; $i < count($time); $i ++){
                    $array = json_encode(array('status' => false, 'duration' => $time[$i], 'date_of_activation' => null, 'expiry_date' => null));

                    $string = "rough";
                    // die("Working on it");

                    $this->req_obj->update( $key, "slot1", $string);
                    
                    die;
                }
            } 
        }
    }

?>