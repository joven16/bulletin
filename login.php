<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\LoginController;

$loginController = new LoginController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginController->processLogin();
} else {
    $loginController->showLoginForm();
}
?>
