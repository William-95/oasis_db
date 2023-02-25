<?php

class Database
{
  private $hostname = "localhost:3307";
  private $dbname = "oasis_db";
  private $user = "root";
  private $pass = "Camilla1204";
  public $conn;

  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->hostname . ";dbname=" . $this->dbname,
        $this->user,
        $this->pass
      );
      $this->conn->exec("set names utf8");
    } catch (PDOException $e) {
      echo "Errore: " . $e->getMessage();
      die();
    }

    return $this->conn;
  }
}
