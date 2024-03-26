<?php

namespace App\Repositories;

use DBConnection;

class CommentsRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::connect();
    }

    public function getComments($id, $user_id)
    {
        $statement = $this->db->query("
        SELECT c.*, u.username FROM comments c
                INNER JOIN users u ON c.user_id = u.id 
                WHERE c.news_id ='$id' ");
        $comments = $statement->fetchAll($this->db::FETCH_ASSOC);
        echo json_encode($this->getTimeDiff($comments));
    }

    public function store($requestData)
    {
        $stmt = $this->db->prepare("INSERT INTO comments (body, created_at, news_id, user_id) VALUES (?, NOW(), ?, ?)");

        $stmt->bindParam(1, $requestData['body']);
        $stmt->bindParam(2, $requestData['news_id']);
        $stmt->bindParam(3, $requestData['user_id']);

        $stmt->execute();

        // Return the last inserted ID
        return $this->db->lastInsertId();
    }

    public function getTimeDiff($comments) 
    {
        date_default_timezone_set('Asia/Singapore');

        $currentTimestamp = time();
        foreach ($comments as &$item) {
            $createdAtTimestamp = strtotime($item['created_at']);
            $minutesDifference = floor(($currentTimestamp - $createdAtTimestamp) / 60);

            if ($minutesDifference < 60) {
                $timeAgo = $minutesDifference . "min ago";
            } elseif ($minutesDifference < 1440) {
                $hours = floor($minutesDifference / 60);
                $timeAgo = $hours . "h ago";
            } else {
                $days = floor($minutesDifference / 1440);
                $timeAgo = $days . "d ago";
            }

            $item['time_difference'] = $timeAgo;
            $item['date_posted'] = date("Y-m-d", $createdAtTimestamp);
        }

        return $comments;
    }
}