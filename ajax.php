 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './partials/Database.php';
// require_once './partials/users.php';


class User extends Database {
    protected $tableName = 'usertable';

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
                error_log("Error: " . $e->getMessage());
                $this->conn->rollBack();
                return false;
            }
        }
        return false;
    }

    public function getRows($start=0, $limit=4) {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public function getUserById($id) {
        // Prepare the SQL statement to select a user by ID
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        
        // Bind the ID parameter to the SQL statement
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the user data as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCount() {
        $sql = "SELECT count(*) as pcount FROM {$this->tableName}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function uploadPhoto($file) {
        if (!empty($file)) {
            $fileTempPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $allowedExtn = ["png", "jpg", "jpeg", "jfif"];
            if (in_array($fileExtension, $allowedExtn)) {
                $uploadFileDir = getcwd() . '/uploads/';
                $desFilePath = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTempPath, $desFilePath)) {
                    return $newFileName;
                }
            }
        }
        return null; // Return null if upload fails
    }
    //function to update 
    
    public function update($data, $id) {
        if (!empty($data)) {
            $fields = [];
            foreach ($data as $field => $value) {
                $fields[] = "{$field} = :{$field}";
            }
            $sql = "UPDATE {$this->tableName} SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $data['id'] = $id;
 
            try {
                $this->conn->beginTransaction();
                $stmt->execute($data);
                $this->conn->commit();
                return true; // Return true on success
            } catch (PDOException $e) {
                $this->conn->rollBack();
                error_log("Error: " . $e->getMessage());
                return false; // Return false on error
            }
        }
        return false; // Return false if no data to update
    }
    
    //delete dunction
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
}


  
$action = $_REQUEST['action'] ?? '';
$obj = new User();

if ($action === 'adduser' && !empty($_POST)) {
    // Check if we are editing an existing user
    $userId = $_POST['userId'] ?? null; // Assuming userId is passed in the form

    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'mobile' => $_POST['mobile'],
        'image' => isset($_FILES['image']) ? $obj->uploadPhoto($_FILES['image']) : null
    ];

    if ($userId) {
        // Update existing user
        $updated = $obj->update($data, $userId);
        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User could not be updated']);
        }
    } else {
        // Add new user
        $userId = $obj->add($data);
        if ($userId) {
            echo json_encode(['status' => 'success', 'data' => $userId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User could not be added']);
        }
    }
    exit();
}

if ($action === "getallusers") {
    $page = $_GET['page'] ?? 1;
    $limit = 4;
    $start = ($page - 1) * $limit;
    $users = $obj->getRows($start, $limit);
    $total = $obj->getCount();
    echo json_encode(['status' => 'success', 'data' => ['count' => $total, 'users' => $users]]);
    exit();
}

if ($action === "edituserdata") {
    $userId = $_GET['id'] ?? '';
    if (!empty($userId)) {
        $user = $obj->getUserById($userId);
        if ($user) {
            echo json_encode(['status' => 'success', 'data' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
        exit();
    }
}

//action to perform eidting
// if($action=="edituserdata"){
//     $playerId = (!empty($_GET['id']))? $_GET['id'] : '';
//     if(!empty($playerid)){
//         $user = $obj->getRows('id',$playerId);
//         echo json_encode($user);
//         exit();
//     }

// }
//action to perform deleting 
if ($action === "deleteuser") {
    $userId = $_GET['id'] ?? '';
    if (!empty($userId)) {
        $delete = $obj->deleteRow($userId);
        if ($delete) {
            $displaymessege = ['delete'=>1];
        } else {
            $displaymessege = ['delete'=>0];
        }
        echo json_encode($displaymessege);
        exit();
    }
}

?> 