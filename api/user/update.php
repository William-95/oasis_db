<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:PUT");
header("Content-Type: application/json; charset=UTF-8");

include_once "..\..\config\database.php";
include_once "..\..\models\user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->password) &&
    !empty($data->confirm_password)
  ) {
$user->id = $data->id;
$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;
$user->confirm_password=$data->confirm_password;

if ($user->update()) {
  http_response_code(200);
  echo json_encode(["risposta" => "Corso aggiornato"]);
} else {
  //503 service unavailable
  http_response_code(503);
  echo json_encode(["risposta" => "Impossibile aggiornare il corso"]);
}
}
?>