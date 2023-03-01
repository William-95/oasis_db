<?php
class LoginUser
{
  private $conn;
  private $table_name = "user";
  // proprietà user
  
  public $name;
  // public $email;
  public $password;
 

  // costruttore
  public function __construct($db)
  {
    $this->conn = $db;

  }

  // LOGIN USER
  function login()
  {
    $query =
      "SELECT * FROM user WHERE name=:name AND password=:password";

    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->password = htmlspecialchars(strip_tags($this->password));

    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":password", $this->password);

    $stmt->execute();
    return $stmt;
  }

}

