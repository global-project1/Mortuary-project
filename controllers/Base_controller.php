<?php

    class Base_controller{
        private $page;

        private function render(){
            require_once $_SESSION['root_dir'] . $this->page;
        }

        function home($page = null){
            $this->page = '/views/'. $page .'.php';
            $this->render();
        }

        function signIn(){            
            $userObj = new Emp_controller();
            $signin = $userObj->sel_employee();

            if(! $signin){
                $this->home("login");
            }
           header("Location: /otp");
        }

        function otp(){
            if(isset($_SESSION['corpse_remover'])){
                extract($_SESSION['corpse_remover']);

            }
            else{
                $userObj = new Emp_controller();
                $otp = $userObj->sel_employee();
    
                if($otp){
                   header("Location: /dashboard");
                }
                else{
                    header("Location: /login");
                }
            }
        }

        function schedule(){
            $schObj = new Cscheduling_controller();
            $schedule = $schObj->corpse();

            if($schedule){
                header("location: /otp");
            }else{
                header("location: /corpseScheduling");
            }
        }

        function logout(){
            session_destroy();
            header("Location: /index");
        }
    }
?>