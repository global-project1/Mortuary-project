<?php

    session_start();

    if($_REQUEST['id']){  
        $id = $_REQUEST['id'];

        if(isset($_SESSION['all_corpse'])){         
            $corpses = $_SESSION['all_corpse'];

            foreach($corpses as $corpse){
                if($corpse['id'] == $id){
                    print_r(json_encode($corpse));
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