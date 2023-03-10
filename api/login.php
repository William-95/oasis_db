<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:POST");
header("Content-Type: application/json; charset=UTF-8");

include_once "..\config\database.php";
include_once "..\models\loginUser.php";

$database = new Database();
$db = $database->getConnection();

$user = new LoginUser($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->name) &&
  !empty($data->password) 
  
) {
$user->name=$data->name;
$user->password=$data->password;

$stmt = $user->login();
$num = $stmt->rowCount();

if ($num > 0) {
  $_GET["user"] = [];
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
}
else {
  http_response_code(404);
  echo json_encode(["message" => "Nessun Corso Trovato."]);
}
}
// else{
//   echo json_encode(["message" => "Nessun Corso Trovato."]);
// }
?>
