<?php

namespace App\Repositories;

use DBConnection;

class NewsRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::connect();
    }

    public function getNews($id)
    {
        $statement = $this->db->query("SELECT * FROM news WHERE id = '$id'");
        $news = $statement->fetchAll($this->db::FETCH_ASSOC);
        echo json_encode($this->getTimeDiff($news));
    }

    public function getAllNews()
    {
        $statement = $this->db->query("SELECT * FROM news ORDER BY id DESC");
        $news = $statement->fetchAll($this->db::FETCH_ASSOC);
        return $this->getTimeDiff($news);
    }

    public function store($requestData)
    {
        $stmt = $this->db->prepare("INSERT INTO news (title, body, user_id, created_at) VALUES (?, ?, ?, NOW())");

        $stmt->bindParam(1, $requestData['title']);
        $stmt->bindParam(2, $requestData['body']);
        $stmt->bindParam(3, $requestData['user_id']);
        

        $stmt->execute();

        // Return the last inserted ID
        return $this->db->lastInsertId();
    }

    public function deleteNews($requestData)
    {
        if (isset($requestData['id'])) {
            // Delete comments associated with the news item
            $deleteCommentsQuery = "DELETE FROM comments WHERE news_id = ?";
            $deleteCommentsStatement = $this->db->prepare($deleteCommentsQuery);
            $deleteCommentsStatement->bindParam(1, $requestData['id'], $this->db::PARAM_INT);
            $deleteCommentsResult = $deleteCommentsStatement->execute();
            
            // Delete the news item
            $deleteNewsQuery = "DELETE FROM news WHERE id = ?";
            $deleteNewsStatement = $this->db->prepare($deleteNewsQuery);
            $deleteNewsStatement->bindParam(1, $requestData['id'], $this->db::PARAM_INT);
            $deleteNewsResult = $deleteNewsStatement->execute();
            
            // Return true if both delete operations were successful
            return $deleteCommentsResult && $deleteNewsResult;
        } else {
            return false;
        }
    }

    public function getTimeDiff($news) 
    {
        date_default_timezone_set('Asia/Singapore');

        $currentTimestamp = time();
        foreach ($news as &$item) {
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


            $commentsStatement = $this->db->query("SELECT * FROM comments WHERE news_id = {$item['id']}");
            $comments = $commentsStatement->fetchAll($this->db::FETCH_ASSOC);
            $item['comments'] = $comments;

            $userAccount = $this->db->query("SELECT * FROM users WHERE id = {$item['user_id']}");
            $user = $userAccount->fetchAll($this->db::FETCH_ASSOC);
            $item['user'] = $user;
        }

        return $news;
    }
}