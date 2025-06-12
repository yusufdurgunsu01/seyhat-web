<?php

class User {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function findByEmailAndPassword($email, $password) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return null;
}


  public function emailExists($email) {
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

public function register($email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Şifreyi hash'le
    $stmt = $this->conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);
    return $stmt->execute();
}

}
