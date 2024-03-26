<?php

namespace App\Controllers;

use App\Services\NewsService;
use App\Models\NewsModel;

class NewsController
{
  private $newsService;
	private $newsModel;

  public function __construct()
  {
    $this->newsService = new NewsService();
		$this->newsModel = new NewsModel();
  }

	public function getNews()
  {
			$id = $_GET['id'];
      return $this->newsService->getNews($id);
  }

  public function getAllNews()
  {
      return $this->newsService->getAllNews();
  }

	public function store()
  {
	$validationResult = $this->newsModel->validate($_POST);

		if ($validationResult['success']) {
        $storeResult = $this->newsService->store($_POST);
        if ($storeResult) {
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
  }

	public function deleteNews()
	{
		return $this->newsService->delete($_POST);
	}
}