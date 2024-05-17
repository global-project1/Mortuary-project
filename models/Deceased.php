<?php

    class Deceased{
        private $conn, $tableName = "Deceased";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }

        function save($postArray, $photo = 'default.jpg'){
            extract($postArray);

            try{
                $insert = "INSERT INTO {$this->tableName}(fname, lname, occupation, marital_status, gender, DOB, DOD, POD, cause, deposit_date, removal_date, picture, cat_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $this->conn->prepare($insert);
                $array = array($fname, $lname, $occupation, $married, $sex, $DOB, $DOD, $place, $text, $dodepo, $dor, $photo, $corpse_cat);

                for($i = 0; $i < count($array); $i++){
                    $stmt->bindValue($i+1, $array[$i]);
                }

                if(! $stmt->execute()){
                    return [False, $this->conn->lastErrorMsg()];   
                }

                return [True, 'success'];        
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

        function read_one($unq_col = null, $value = null){
            try{
                $value = $this->conn->escapeString($value);
    
                $select = "SELECT * FROM {$this->tableName} WHERE $unq_col = ?";
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

        function delete_one($unq_col, $value){
            $data = $this->read_one($unq_col, $value);
            
            if(!$data){    
                return false;
            }

            if($data['picture'] !== 'default.jpg'){
                $file1 = 'assets/images/'.$data['picture'];
                if(file_exists($file1)){
                    unlink($file1);
                }
            }

            $delete = "DELETE FROM $this->tableName WHERE $unq_col = ?";
            $stmt = $this->conn->prepare($delete);

            $stmt->bindValue(1, $value);

            if(! $stmt->execute()){   
                return false;
            }

            return true;   
        }

    }

?>