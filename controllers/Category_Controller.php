<?php

    class Category_Controller{
        private $cat_obj;

        function __construct(){
            $this->cat_obj = new Categories();
        }

        function get_categories(){       
            $cats = $this->cat_obj->read();

            if($cats){
                return [true, $cats];
            }

            return [false, "No result found"];
        }

        function update_cat($string = null, $id = null){
            if(!$string && !$id){
                $vip = $vvip = $standard = 0;
                foreach($_SESSION['all_corpse'] as $corp){
                    extract($corp);
            
                    if($cat_name === 'VIP'){
                        $vip++;
                    }elseif($cat_name === 'VVIP'){
                        $vvip++;
                    }else{
                        $standard++;
                    }
                }

                $_SESSION['cats'] = array('vip' => $vip, 'standard' => $standard, 'vvip' => $vvip);
    
                $string = "tot_corpse = $vip WHERE cat_name = 'VIP'";
                $this->cat_obj->update($string = $string);

                $string = "tot_corpse = $vvip WHERE cat_name = 'VVIP'";
                $this->cat_obj->update($string = $string);

                $string = "tot_corpse = $standard WHERE cat_name = 'Standard'";
                $this->cat_obj->update($string = $string);
            }

            else{
                [$state, $msg] = $this->cat_obj->update($string, $id);
                if(! $state){
                    $_SESSION['dash_msg'] = array( 
                        'status' => false,
                        'msg' => "An error occured while updating the corpse information"
                    );
                }else{
                    $_SESSION['dash_msg'] = ['status' =>true, 'msg' => 'category updated successfully'];
                }
            }
        }
    }


?>