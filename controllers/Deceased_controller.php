<?php

    class Deceased_controller{
        private $photo = null, $dsc_obj, $tmp_dir;

        function __construct(){
            $this->dsc_obj = new Deceased();  
            $this->clear_expired();         
        }

        private function clear_expired(){
            [$state, $results] = $this->dsc_obj->read("WHERE otp IS NOT NULL");
            if(empty($results)){
                unset($_SESSION['corpse_remover']);
            }
            
            foreach($results as $res){
                $time = $res['otp_expire'];
                if(time() > $time){
                    $string = "otp = NULL, otp_expire = NULL";
                    $id = $res['id'];

                   $state = $this->dsc_obj->update($string, $id);
                }
            }
        }

        function set_picture(){
            if(! empty($_FILES['picture']['name'])){
                $this->photo = $this->profilePicHandler($_FILES['picture']);
                return $this->photo;
            }
            else{
                return null;
            }
        }

        // Profile pic handler
        public function profilePicHandler($setPicture, $table=null){
            $ext = $this->profilePicVerify($setPicture);

            if( !$ext){
                $_SESSION['dash_msg'] = array( 
                    'status' => false,
                    'msg' => $_SESSION['pic_err']
                );
                header("Location: /dashboard");
                exit(); 
            }
            
            // I need the length of the lone name, inorder to produce a new name of atmost 3 xters
            $len = strlen($ext[1]);
            $name = ($len > 2)? substr($ext[1], 0, 2): $ext[1];
            $name = $this->renameFile($ext[0], $name, $table);

            $this->tmp_dir = $setPicture['tmp_name'];

            return $name;      
        }

        // Picture conformity checks

        function profilePicVerify($picArray){
            $name = $picArray['name'];
            $ext = $this->checkExtension($name);

            if( !$ext){
                $_SESSION['pic_err'] = "Invalid file extension";
                return false;
            }

            if( !$this->checkSize($picArray['size'] )){
                $_SESSION['pic_err'] = "File too large";
                return false;
            }
            return $ext;
        }

        // picture extension checks

        public function checkExtension($name){
            $extensions = ['png', 'jpg', 'avif', 'jpeg', 'svg', 'webp', 'gif', 'bmp', 'ico', 'tif', 'tiff'];

            $name = explode('.', $name);
            $ext = strtolower(end($name));

            if(! in_array($ext, $extensions)){
                return false;      
            }
            return [$ext, $name[0]];
        }

        // picture size checking

        public function checkSize($size){
            if($size > 1000000){
                return false;
            }
            return true;
        }

        // rename the profile pic from file

        public function renameFile($fileExt = null, $xters = null, $table = null){
            $id = 1;
            $oldId =  $_SESSION['root_dir'] . "/models/storage/id.txt";

            if(file_exists($oldId)){
                $fp = fopen($oldId, 'r');
                $id = fgets($fp);
                $id ++;
            }

            $new_name = str_shuffle($xters.$id).'.'.$fileExt;

            $fp = fopen($oldId, 'w');
            fwrite($fp, $id);
            fclose($fp);

            return $new_name;
        }
        
        // Register corpse now

        public function add_corpse(){   
            [$state, $msg] = $this->dsc_obj->save($_POST, $this->photo);
            
            if($state){     
                // Upload the image to the img_dir
                $targetDir = "assets/images/{$this->photo}";
                try{
                    move_uploaded_file($this->tmp_dir, $targetDir);
                    $_SESSION['dash_msg'] = ['status' =>true, 'msg' => 'Corpse added successfully and '. $msg];

                    // send mail to the guardian
                    return;

                }catch(Exception $e){
                    $_SESSION['dash_msg'] = ['status' =>false, 'msg' => 'Corpse added but image failed to upload'];
                }
            }else{
                $_SESSION['dash_msg'] = ['status' =>false, 'msg' => $msg];
            }   
        }
        
        //Get corpse

        function get_corpse($cond = null){
            return $this->dsc_obj->read($cond);
        }

        function update_corpse($string, $id){      
            [$state, $msg] = $this->dsc_obj->update($string, $id);
            if(! $state){
                $_SESSION['dash_msg'] = array( 
                    'status' => false,
                    'msg' => "An error occured while updating the corpse information"
                );

            }else{
                // Upload the image to the img_dir
                $targetDir = "assets/images/{$this->photo}";
                try{
                    move_uploaded_file($this->tmp_dir, $targetDir);
                    $_SESSION['dash_msg'] = ['status' =>true, 'msg' => 'corpse information updated successfully'];
                    return;

                }catch(Exception $e){
                    $_SESSION['dash_msg'] = ['status' =>false, 'msg' => 'Error updating the image'];
                }
            }
        }

        function delete_all_corpse(){
            if($this->dsc_obj->delete_all()){
                $_SESSION['dash_msg'] = ['status' =>true, 'msg' => "user deleted successfully"];
            }
            else{
                $_SESSION['dash_msg'] = ['status' =>true, 'msg' => "Error deleting user"];
            }
            return;
        }

        function delete_corpse($id){
            if($this->dsc_obj->delete_one($id)){
                $_SESSION['dash_msg'] = ['status' =>true, 'msg' => "user deleted successfully"];
            }
            else{
                $_SESSION['dash_msg'] = ['status' =>true, 'msg' => "Error deleting user"];
            }
            return;
        }
    }
?>