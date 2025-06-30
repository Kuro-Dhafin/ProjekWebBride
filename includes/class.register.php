<?php
require_once 'config.php';

class Register {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function isEmailTaken($email) {
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->rowCount() > 0;
  }

  public function registerUser($data) {
    $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, notelp, birth, address, password, user_type, company_name, service_type)
            VALUES (:username, :email, :notelp, :birth, :address, :password, :user_type, :company_name, :service_type)";
    
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      ':username' => $data['username'],
      ':email' => $data['email'],
      ':notelp' => $data['notelp'],
      ':birth' => $data['birth'],
      ':address' => $data['address'],
      ':password' => $hashedPassword,
      ':user_type' => $data['user_type'],
      ':company_name' => $data['user_type'] === 'vendor' ? $data['company_name'] : null,
      ':service_type' => $data['user_type'] === 'vendor' ? $data['service_type'] : null
    ]);
  }
}
?>
