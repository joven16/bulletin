<?php

namespace App\Models;

class CommentsModel
{
    public function validate($requestData)
    {
        $errors = [];

        if (empty($requestData['body'])) {
            $errors[] = 'Comment is required.';
        }

        if (empty($errors)) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $errors];
        }
    }

}
