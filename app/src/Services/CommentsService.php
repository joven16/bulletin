<?php

namespace App\Services;

use App\Repositories\CommentsRepository;

class CommentsService
{
    private $commentsRepository;

    public function __construct()
    {
        $this->commentsRepository = new CommentsRepository();
    }

    public function getComments($id, $user_id)
    {
        return $this->commentsRepository->getComments($id, $user_id);
    }

    public function store($requestData)
    {
        return $this->commentsRepository->store($requestData);
    }
}