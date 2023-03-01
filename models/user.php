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
  public $confirm_password;

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
    name=:name, email=:email, password=:password, confirm_password=:confirm_password";

    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->confirm_password = htmlspecialchars(strip_tags($this->confirm_password));

    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":confirm_password", $this->confirm_password);

   
    if ($stmt->execute()) {
      
      return true;
    }


    return false;
  }


  // AGGIORNARE UTENTE
  function update()
  {
    $query =
      "UPDATE
                    " .
      $this->table_name .
      "
                SET
                name = :name,
                email = :email,
                password=:password,
                confirm_password=:confirm_password
                WHERE
                id = :id";

    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->confirm_password = htmlspecialchars(strip_tags($this->confirm_password));

    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":confirm_password", $this->confirm_password);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
  // CANCELLARE UTENTE
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";

    $newquery = filter_var($query, FILTER_SANITIZE_STRING);
    $stmt = $this->conn->prepare($newquery);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam("id", $this->id);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
