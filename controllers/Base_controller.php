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

            return $signin;
        }

        function signUp(){
            
        }

        function logout(){
            session_destroy();
            header("Location: /index");
        }
    }
?>