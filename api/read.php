<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods:GET');
header("Content-Type: application/json; charset=UTF-8");

include_once "..\config\database.php";
include_once "..\models\user.php";

$database= new Database();

$db =$database->getConnection();

$user=new User($db);

$stmt= $user->read();
$num = $stmt->rowCount();

if($num>0){
    $_GET["user"]=[];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
    
        $user_item = [
          "id" => $id,
          "name" => $name,
          "email" => $email,
          "password" => $password,
        ];
         array_push($_GET["user"], $user_item);
      }
      http_response_code(200);
      echo json_encode($_GET);
    } else {
      http_response_code(404);
      echo json_encode(["message" => "Nessun Utente Trovato."]);
    }
    
