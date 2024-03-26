<?php

namespace App\Models;

class NewsModel
{
    public function validate($requestData)
    {
        $errors = [];

        if (empty($requestData['title'])) {
            $errors[] = 'Title is required.';
        }

        if (empty($requestData['body'])) {
            $errors[] = 'Content is required.';
        }

        if (empty($errors)) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $errors];
        }
    }

}
