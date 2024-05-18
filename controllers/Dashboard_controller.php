<?php

    class Dashboard_controller{
        private $cat_obj, $dsc_obj;

        function __construct(){
            $this->cat_obj = new Category_Controller();
            $this->dsc_obj = new Deceased_controller();
        }

        private function render(){
            $this->get_cats();
            require_once $_SESSION['root_dir'] . '/views/dashboard.php';
        }

        function index(){
            $this->get_corpse();
            $this->render();
        }
        
        function get_cats(){
            if(! isset($_SESSION['categories'])){
                [$state, $data] =  $this->cat_obj->get_categories();
                $_SESSION['categories'] = ($state) ? $data : array();
            }
        }

        function get_corpse($condition = null){
            [$state, $data] = $this->dsc_obj->get_corpse($condition);
            $_SESSION['corpse'] = ($state) ? $data : array();
        }

        function examine_post(){
            switch($_POST['option']){
                case 'add':
                    $this->add();
                    break;
                
                case 'order':
                    $this->order();
                    break;
                
                case 'search':
                    $this->search();
                    break;

                case 'delete':
                    $this->remove();
                    break;

                default:
                    $this->render();
                    break;
            }
        }

        private function add(){
            $this->dsc_obj->set_picture();
            $this->dsc_obj->add_corpse();

            $this->index();
        }

        private function order(){
            if(isset($_POST['order_by_cat'])){
                $condition = "WHERE ds.cat_id = ". $_POST['order_by_cat'];

            }elseif(isset($_POST['order_by_date'])){
                if(isset($_POST['asc'])){
                    $condition = "ORDER BY DOD ASC";
                }
                else{
                    $condition = "ORDER BY DOD DESC";
                }
            }else{
                if(isset($_POST['female'])){
                    $condition = "WHERE gender = 'F'";

                }else{
                    $condition = "WHERE gender = 'M'";
                }
            }
            $this->get_corpse($condition);
            $this->render();
        }

        // Search method

        function search(){
            $search_string = $_POST['search'];

            for($i = strlen($search_string); $i > 0; $i--){
                $string = '';
                for($j = 0; $j < $i; $j++){
                    $string .= $search_string[$j]; 
                }

                $cond = "WHERE fname like '%$string%' OR lname like '%$string%'";

                [$state, $data] = $this->dsc_obj->get_corpse($cond);
                if($state){
                    break;
                }
            }
            $_SESSION['corpse'] = ($state) ? $data : array();
            $this->render();
        }

        function remove(){
            $this->dsc_obj->delete_corpse($_POST['hiddenID']);

            $this->index();
        }
    }

?>