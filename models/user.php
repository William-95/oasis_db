<?php

class User
{
  private $conn;
  private $table_name = "user";
  // proprietà user
  public $id;
  public $name;
  public $email;
  public $password;

  // costruttore
  public function __construct($db)
  {
    $this->conn = $db;

  }

  // READ USER
  function read()
  {
    $query =
      "SELECT * FROM user";

    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $stmt->execute();
    return $stmt;
  }
  // CREARE USER
  function create()
  {
    $query =
      "INSERT INTO
    " .
      $this->table_name .
      "
SET
    name=:name, email=:email, password=:password";

// $query="INSERT INTO user(id,name,email,password) VALUES (null,:name,:email,:password)";
    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(
      strip_tags($this->email)
    );
    $this->password = htmlspecialchars(strip_tags($this->password));


    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);

    if ($stmt->execute()) {
      return true;
    }


    return false;
  }
}