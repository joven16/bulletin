<?php
// routes.php

require_once __DIR__ . '/vendor/autoload.php';
use App\Controllers\NewsController;
use App\Controllers\CommentsController;

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Create an instance of the NewsController
    $newsController = new NewsController();
    $commentsController = new CommentsController();

    // Call the appropriate method based on the action
    switch ($action) {
        case 'create':
            $newsController->store();
            break;
        case 'get':
            $newsController->getNews();
            break;    
        case 'delete':
            $newsController->deleteNews();
            break;
        case 'get-comment':
            $commentsController->getComments();
            break;    
        case 'create-comment':
            $commentsController->store();
            break;    
        // Add more cases for other actions as needed
        default:
            // Handle unknown actions
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
            break;
    }
}
?>
