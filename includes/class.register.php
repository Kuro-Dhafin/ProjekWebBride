<?php
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
    try {
        $stmt = $this->conn->prepare("INSERT INTO users 
            (name, email, password, role, phone, birth, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        return $stmt->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['user_type'],
            $data['notelp'],
            $data['birth'],
            $data['address']
        ]);
    } catch (PDOException $e) {
        echo "Register Failed: " . $e->getMessage(); // Debug sementara
        return false;
    }
}

}

?>
