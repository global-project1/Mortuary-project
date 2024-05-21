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
            $_SESSION['userInfo'] = $signin;

            header("Location: /otp");
            exit;
        }

        function otp(){
            if(isset($_SESSION['corpse_remover'])){
                $schObj = new Cscheduling_controller();
                $schedule = $schObj->manage_otp();

            }
            else{
                $userObj = new Emp_controller();
                $otp = $userObj->sel_employee();
    
                if($otp){
                   header("Location: /dashboard");
                   exit;
                }
                else{
                    header("Location: /login");
                    exit;
                }
            }
        }

        function schedule(){
            $schObj = new Cscheduling_controller();
            $schedule = $schObj->corpse();

            if($schedule){
                header("Location: /otp");
            }else{
                header("Location: /request");
            }
        }

        function logout(){
            session_destroy();
            header("Location: /index");
        }

        function slot(){

        }
    }
?>