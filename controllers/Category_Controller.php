<?php

    class Category_Controller{
        private $catObj;

        function __construct(){
            $this->catObj = new Categories();
        }

        function get_categories(){       
            $cats = $this->catObj->read();

            if($cats){
                return [true, $cats];
            }

            return [false, "No result found"];
    
        }
    }


?>