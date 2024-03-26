<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Models\NewsModel;

class NewsService
{
    private $newsRepository;
    private $newsModel;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
        $this->newsModel = new NewsModel();
    }

    public function getNews($id)
    {
        return $this->newsRepository->getNews($id);
    }

    public function getAllNews()
    {
        return $this->newsRepository->getAllNews();
    }

    public function store($requestData)
    {
        return $this->newsRepository->store($requestData);
    }

    public function delete($requestData)
    {
        return $this->newsRepository->deleteNews($requestData);
    }

    public function validate($data)
    {
        return $this->newsModel->validate($data);
    }
}