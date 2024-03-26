<?php

namespace App\Models;

use DBConnection;

class User {
    
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::connect();
    }

    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch($this->db::FETCH_ASSOC);
    }

    public function validateCredentials($username, $password) {
        $user = $this->getUserByUsername($username);
        $hash = password_hash($user['password'], PASSWORD_BCRYPT);
        if ($user && password_verify($password, $hash)) {
           return $user;
        }
        return false;
    }
}
?>
