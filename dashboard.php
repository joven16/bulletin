<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit;
}

$username = $_SESSION["username"];

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/routes.php';

use App\Controllers\NewsController;

$news = new NewsController();
$allNews = $news->getAllNews();

function ellipsisText($text, $length) {
  if (strlen($text) > $length) {
      $text = substr($text, 0, $length - 3) . '...';
  }
  return $text;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletin Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
	  rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
	<style>
      .card {
          margin-bottom: 20px;
          padding: 10px;
      }
  </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Bulletin Board</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= $username; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sign out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Create Article Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="create" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="create">New article</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#errorContainer').empty();"></button>
      </div>
      <div class="modal-body">
	  <div id="errorContainer" class="text-danger"></div>
      <input type="hidden" id="article-user-id" value="<?=$_SESSION['id']; ?>">
	  	<input type="text" class="form-control" id="news-title" placeholder="Title" style="margin-bottom: 10px;">
	  	<textarea class="form-control" id="news-body" placeholder="Your content here..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="post-news">Post it!</button>
      </div>
    </div>
  </div>
</div>

<!-- Article Content Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="view" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="view"><span id="articleTitle"></span></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="p-2">
          <small>Posted by: <span id="a-user"></span> - <i><span id="date"></i></span></small>
					<p class="text-justify" id="content"></p>
				</div>
        <hr>
        <h4>Comments:</h4>
        <div id="comments">
            <!-- Comments will be dynamically added here -->
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary add-comment" type="button" data-bs-toggle="modal" data-bs-target="#commentModal">add comment</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="createComment" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createComment">Add comment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="p-2">
          <input type="hidden" id="comment-user-id" value="<?=$_SESSION['id']; ?>">
          <input type="hidden" id="newsId">
          <small>Posted by: <span id="c-user"></span> <i><span id="cdate"></i></span></small>
					<p class="text-justify" id="ccontent"></p>
				</div>
        <div id="errorContainerComment" class="text-danger"></div>
	  	  <textarea class="form-control" id="comment-body" placeholder="Write your comment here..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="post-comment">Post</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="createComment" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createComment">Warning!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="p-2">
          <input type="hidden" id="d-newsId">
					<p class="text-justify">Deleting article <strong>"<span id="d-article"></span></strong>" and its comments?</p>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="delete-article-post">Yes</button>
      </div>
    </div>
  </div>
</div>


<!-- Posts -->
<div class="container mt-5 mb-5">
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-6">

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary create-article" type="button" data-bs-toggle="modal" data-bs-target="#createModal">Create a new aticle!</button>
      </div>
      <hr>

      <?php foreach ($allNews as $news) : ?>
        <div class="card" data-bs-toggle="modal" data-bs-target="#viewModal" id="<?= $news['id']; ?>">
          <?php if ($_SESSION['id'] === $news['user_id']) { ?>
          <button type="button" class="btn-close delete-article" data-bs-toggle="modal" data-bs-target="#deleteModal" id="<?= $news['id']; ?>" style="margin-left: auto;"></button>
          <?php } ?>
          <div class="d-flex justify-content-between p-2 px-3">
            <div class="d-flex flex-row align-items-center">
              <div class="d-flex flex-column ml-2"> <span class="font-weight-bold"><strong><?= $news['title']; ?></strong> - <?= $news['date_posted']; ?></span> </div>
            </div>
            <div class="d-flex flex-row mt-1 ellipsis"> 
              <small class="mr-2" data-toggle="tooltip" title="<?= $news['time_difference']; ?>"><i><?= $news['time_difference']; ?></i></small>
              <i class="fa fa-ellipsis-h"></i> <i class="fa fa-ellipsis-h"></i> 
            </div>
          </div>
          <div class="p-2">
            <p class="text-justify">
              <?= ellipsisText($news['body'], 100); ?>
            </p>
            - <?=$news['user'][0]['username']; ?>
          </div>
        </div>
      <?php endforeach; ?>
      <br>
    </div>
  </div>
</div>

</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/bulletin.js"></script>

</html>