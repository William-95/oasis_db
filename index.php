<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include 'config\database.php';

$db= new Database;
$conn=$db->connect();

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case "POST":
        $user=json_decode(file_get_contents('php://input'));
        $sql="INSERT INTO user(id,name,email,password) VALUES ( NULL,:name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', $user->password);

        if($stmt->execute()){
            $response=['status'=>1,'message'=>'Record created successfully.'];
        }else{
            $response=['status'=>0,'message'=>'Failed to create record.'];

        }
        break;
}
