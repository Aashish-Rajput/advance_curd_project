<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'partials/user.php';
    $obj = new user(); // Ensure this matches the class name
}

// Adding user action
if ($action == 'adduser' && !empty($_POST)) {
    $pname = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $image = isset($_FILES['image']) ? $_FILES['image'] : null; // Check for image input
    $playerid = (!empty($_POST['userid'])) ? $_POST['userid'] : "";
    $imagename = "";

    if ($image && !empty($image['name'])) {
        $imagename = $obj->uploadPhoto($image);
        if (!$imagename) {
            echo json_encode(['status' => 'error', 'message' => 'Image upload failed']);
            exit();
        }
        $playerData = [
            'username' => $pname,
            'email' => $email,
            'mobile' => $mobile,
            'image' => $imagename,
        ];
    } else {
        $playerData = [
            'username' => $pname,
            'email' => $email,
            'mobile' => $mobile,
        ];
    }

    $playerid = $obj->add($playerData);
    if (!empty($playerid)) {
        $player = $obj->getRow('id', $playerid);
        echo json_encode(['status' => 'success', 'data' => $player]);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User could not be added']);
        exit();
    }
}
//getcount of function and getallusers

if ($action == "getallusers") {
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 4;
    $start = ($page - 1) * $limit;

    $users = $obj->getRows($start, $limit);
    $total = $obj->getCount();

    if (!empty($users)) {
        echo json_encode(['status' => 'success', 'data' => ['count' => $total, 'users' => $users]]);
    } else {
        echo json_encode(['status' => 'success', 'data' => ['count' => $total, 'users' => []]]);
    }
    exit();
}
else{     
echo json_encode(['status' => 'error' , 'message'=> 'data cannot be diaplayed']);
}
?>