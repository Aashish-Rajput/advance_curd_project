<?php
require_once 'Database.php';

class user extends Database{
    protected $tableName = 'usertable';


    //funtion to add users
    public function add($data) {
        if (!empty($data)) {
            $fields = [];
            $placeholders = [];
            
            foreach ($data as $field => $value) {
                $fields[] = $field;
                $placeholders[] = ":{$field}";
            }
            
            $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
            
            $stmt = $this->conn->prepare($sql);
            
            try {
                $this->conn->beginTransaction();
                $stmt->execute($data);
                $lastInsertedId = $this->conn->lastInsertId();
                $this->conn->commit();
                return $lastInsertedId; // Return the last inserted ID
            } catch (PDOException $e) {
                // Log the error instead of echoing it
                error_log("Error: " . $e->getMessage());
                $this->conn->rollBack();
                return false; // Optionally return false on error
            }
        }
        return false; // Return false if no data is provided
    }

    //function to get rows 
    public function getRows($start=0,$limit=4){
        $sql = "SELECT * FROM  {$this->tableName} ORDER BY id DESC LIMIT {$start},{$limit}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()>0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $results =[];
        }
        return $results;
    }

    //function to get single row
    public function getRow($field, $value) {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :{$field}";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":{$field}", $value); // Bind the value to the placeholder
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }
    //function to count no of rows
    public function getCount(){
        $sql = "SELECT count(*) as pcount FROM {$this->tableName} ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
        }
    

    //function to upload photo
    public function uploadPhoto($file){
        if(!empty($file)){
            $fileTempPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileType =$file['type'];
            $fileNameCmps = explode('.',$fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time().$fileName).'.'.$fileExtension;
            $allowedExtn = ["png","jpg","jpeg","jfif"];
            if(in_array($fileExtension,$allowedExtn)){
                $uploadFileDir = getcwd().'/uploads/';
                $desFilePath =  $uploadFileDir.$newFileName;
                if(move_uploaded_file($fileTempPath,$desFilePath)){
                   return  $newFileName;

                }

            }

        }
    }

    //function to update 
    
    public function  update($data ,$id){
        if(!empty($data)){
            $fields="";
            $x = 1;
            $fieldscount=count($data);
            foreach($data as $field=>$value){
                $fields.="{$field}=:{$field}"; 
                if($x>$fieldscount){
                    $fields.= ",";
                }
                $x++;

            }
        }
        $sql = "UPDATE {$this->tableName} SET {$fields} where id =:id";
        $stmt = $this->conn->prepare($sql);

        try {
            $this->conn->beginTransaction();
            $data['id'] =$id;
            $stmt->execute($data);
            $this->conn->commit();
      ; // Return the last inserted ID
        } catch (PDOException $e) {
            // Log the error instead of echoing it
            error_log("Error: " . $e->getMessage());
            $this->conn->rollBack();
            return false; // Optionally return false on error
        }


    }


    //function to delete
    public function deleteRow($id){
        $sql = "DELETE FROM {$this->tableName} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute([':id'=>$id]);
            if($stmt->rowCount()>0){
                return true;
            }
       
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false; // Return false on error
        }

    }
    //function for search
}



?>