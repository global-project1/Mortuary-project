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

            if(! $signin[0]){
                $_SESSION['login_error'] = $signin[1];

                $this->home("login");
            }
            unset($_SESSION['corpse_remover']);
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
                unset($_SESSION["userInfo"]);
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
            $schObj = new Cscheduling_controller();
            $schedule = $schObj->save_chosen_slot();
            if($schedule){
                $_SESSION['req_error'] = "Schedule successfully set";
                header("Location: /request");
                exit;
            }

            else{
                $_SESSION['req_error'] = "an Error occured while setting schedule";
                header("Location: /request");
            }
        }
    }
?>