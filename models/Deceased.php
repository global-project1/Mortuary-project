<?php

    class Deceased{
        private $conn, $tableName = "Deceased";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }

        private function generate_key(){
            $string = "M@RTUAY";

            $id = 1;
            $old_id = $_SESSION['root_dir']. '/models/storage/key.txt';

            if(file_exists($old_id)){
                $fp = fopen($old_id, 'r');
                $id = fgets($fp);
                $id++;
            }
            $string = $string.$id;
            $key = str_shuffle($string);
            $key = (strlen($key) > 9)? substr($key, 0, 9): $key;

            $fp = fopen($old_id, 'w');
            fwrite($fp, $id);
            fclose($fp);

            return $key;
        }

        function save($postArray, $photo = 'default.jpg'){
            extract($postArray);      
            $key = $this->generate_key();

            try{
                $insert = "INSERT INTO {$this->tableName} VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $this->conn->prepare($insert);
                $array = array($key, $fname, $lname, $occupation, $marital_status, $gender, $DOB, $DOD, $POD, $cause, $deposit_date, $removal_date, $photo, $cat_id, $guardian_name, $guardian_email, $guardian_relation);

                for($i = 0; $i < count($array); $i++){
                    $stmt->bindValue($i+1, $array[$i]);
                }

                if(! $stmt->execute()){
                    return [False, $this->conn->lastErrorMsg()];   
                }

                return [True, $key];        
            }
            catch(\SQLite3Exception $e){
                return [False, $e];         
            }  
        }

        function read($condition = null){
            try{
                if ($condition){
                    $select = "SELECT * FROM $this->tableName AS ds
                    INNER JOIN 
                    categories AS ct
                    ON ds.cat_id = ct.cat_id
                    $condition";
                }
    
                else{
                    $select = "SELECT * FROM $this->tableName AS ds
                    INNER JOIN 
                    categories AS ct
                    ON ds.cat_id = ct.cat_id";
                }

                $result = $this->conn->query($select);
                if(! $result){
                    return [false, "No such record found"];
                }

                $results = array();

                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    array_push($results, $row);
                }
                // Set the global variable
                if(! $condition){
                    $_SESSION['all_corpse'] = $results;
                }

                return [true, $results];
            }
            catch(Exception $e){
                return [false, $this->conn->lasErrorMsg()];
            }       
        }

        function read_one($value = null){
            try{
                $value = $this->conn->escapeString($value);
    
                $select = "SELECT * FROM {$this->tableName} WHERE id = ?";
                $stmt = $this->conn->prepare($select);
                $stmt->bindValue(1, $value);
                $result = $stmt->execute();
                
                if($result){
                    return $result->fetchArray(SQLITE3_ASSOC);
                }   
                return false;  
            }
            catch(Exception $e){
                return false;
            }
        }

        function update(){
            
        }

        function delete_all(){
            // We Also have to delete the associated pictures, if any

            [$state, $data] = $this->read();
            if(!$state){    
                return false;
            }

            foreach($data as $dt){
                if($dt['picture'] !== 'default.jpg'){
                    $file = 'assets/images/'.$dt['picture'];
                    if(file_exists($file)){
                        unlink($file);
                    }
                }
            }
            $delete = "DELETE FROM $this->tableName";

            if(! $this->conn->exec($delete)){
                return false;
            }
            return true;
        }

        function delete_one($value){
            $data = $this->read_one($value);
            
            if(!$data){    
                return false;
            }
            if($data['picture'] !== 'default.jpg'){
                $file1 = 'assets/images/'.$data['picture'];
                if(file_exists($file1)){
                    unlink($file1);
                }
            }

            $delete = "DELETE FROM $this->tableName WHERE id = ?";
            $stmt = $this->conn->prepare($delete);

            $stmt->bindValue(1, $value);

            if(! $stmt->execute()){   
                return false;
            }
            return true;   
        }
    }
?>