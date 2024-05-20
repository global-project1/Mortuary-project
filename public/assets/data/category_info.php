<?php
    session_start();

    if($_REQUEST['id']){  
        $id = $_REQUEST['id'];

        if(isset($_SESSION['categories'])){         
            $cats = $_SESSION['categories'];

            foreach($cats as $cat){
                if($cat['cat_id'] == $id){
                    print_r(json_encode($cat));
                    exit();
                }
            }
        }
        else{
            echo null;
            exit();
        }
    }

?>