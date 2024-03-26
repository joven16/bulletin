<?php

namespace App\Controllers;

use App\Models\User;

class LoginController {

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLoginForm() {
        // Render login view
        include 'login.php';
    }

    public function processLogin() {
        // Validate form submission
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Authenticate user
            $user = $this->userModel->validateCredentials($username, $password);
            if ($user) {
                session_start();
                $_SESSION["username"] = $user["username"];
                $_SESSION["id"] = $user["id"];
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'errors' => 'Invalid username or password.']);
            }
        }
    }
}
?>
