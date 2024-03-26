<?php

namespace App\Controllers;

use App\Services\CommentsService;
use App\Models\CommentsModel;

class CommentsController
{
  private $commentsService;
  private $commentsModel;

  public function __construct()
  {
      $this->commentsService = new CommentsService();
      $this->commentsModel = new CommentsModel();
  }

  public function getComments()
  {
    $id = $_GET['id'];
    $user_id = $_GET['user_id'];
    return $this->commentsService->getComments($id, $user_id);
  }

	public function store()
  {
	  $validationResult = $this->commentsModel->validate($_POST);

	  if ($validationResult['success']) {
        $storeResult = $this->commentsService->store($_POST);
        if ($storeResult) {
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
  }

}