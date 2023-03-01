<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:DELETE");
header("Content-Type: application/json; charset=UTF-8");

include_once "..\..\config\database.php";
include_once "..\..\models\user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) 
  ) {

$user->id = $data->id;

if ($user->delete()) {
  http_response_code(200);
  echo json_encode(["risposta" => "Il corso e' stato eliminato"]);
} else {
  //503 service unavailable
  http_response_code(503);
  echo json_encode(["risposta" => "Impossibile eliminare il corso."]);
}
  }
?>