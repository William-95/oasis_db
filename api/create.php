<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age: 3600");

include_once "..\config\database.php";
include_once "..\models\user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->name) &&
  !empty($data->email) &&
  !empty($data->password) &&
  !empty($data->confirm_password)
) {
  $user->name = $data->name;
  $user->email = $data->email;
  $user->password = $data->password;
  $user->confirm_password = $data->confirm_password;

  if ($user->create()) {
    http_response_code(201);
    echo json_encode(["message" => "Utente creato correttamente."]);
  } else {
    //503 servizio non disponibile
    http_response_code(503);
    echo json_encode(["message" => "Impossibile creare Lutente."]);
  }
} else {
  //400 bad request
  http_response_code(400);
  echo json_encode([
    "message" => "Impossibile creare l'utente, i dati sono incompleti.",
  ]);
}

?>
