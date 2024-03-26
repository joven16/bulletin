$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

$("#post-news").click(function () {
  var newsTitle = $("#news-title").val();
  var newsBody = $("#news-body").val();
  var userId = $("#article-user-id").val();

  $.post(
    "create",
    { title: newsTitle, body: newsBody, user_id: userId },
    function (response) {
      let parseData = JSON.parse(response);
      if (parseData.errors && parseData.errors.length > 0) {
        $("#errorContainer").empty();

        $.each(parseData.errors, function (index, errorMessage) {
          var errorDiv = $("<div>").text(errorMessage);
          $("#errorContainer").append(errorDiv);
        });
      } else {
        $("#errorContainer").empty();
        alert("Article created!");
        window.location.reload();
      }
    }
  ).fail(function (xhr, status, error) {
    console.error(error);
  });
});

$("#post-comment").click(function () {
  var newsId = $("#newsId").val();
  var commentBody = $("#comment-body").val();
  var userId = $("#comment-user-id").val();
  $.post(
    "create-comment",
    { body: commentBody, news_id: newsId, user_id: userId },
    function (response) {
      let parseData = JSON.parse(response);
      if (parseData.errors && parseData.errors.length > 0) {
        $("#errorContainerComment").empty();

        $.each(parseData.errors, function (index, errorMessage) {
          var errorDiv = $("<div>").text(errorMessage);
          $("#errorContainerComment").append(errorDiv);
        });
      } else {
        $("#errorContainerComment").empty();
        loadComments(newsId, userId);
        alert("Comment saved!");
        $("#commentModal").modal("hide");
        $("#comment-body").val("");
      }
    }
  ).fail(function (xhr, status, error) {
    console.error(error);
  });
});

function loadComments(id, user_id) {
  $.get("get-comment", { id: id, user_id: user_id }, function (response) {
    // console.log(response);
    let parseData = JSON.parse(response);
    let data = parseData;
    // console.log(data);

    var comments = $("#comments");
    comments.empty();

    data.sort(function (a, b) {
      return new Date(b.created_at) - new Date(a.created_at);
    });

    $.each(data, function (index, comment) {
      var commentHtml =
        '<div class="comment">' +
        "<small><i>" +
        comment.created_at +
        "</i></small>" +
        " by: <small><i>" +
        comment.username +
        "</i></small>" +
        "<p>" +
        comment.body +
        "</p>" +
        "</div>";
      comments.append(commentHtml);
    });
  }).fail(function (xhr, status, error) {
    console.error(error);
  });
}

$(".card").click(function () {
  $("#errorContainerComment").empty();
  var articleId = $(this).attr("id");
  $("#newsId").val(articleId);
  $("#d-newsId").val(articleId);

  $.get("get", { id: articleId }, function (response) {
    let parseData = JSON.parse(response);
    let data = parseData[0];

    $("#articleTitle").text(data.title);
    $("#a-user").text(data.user[0].username);
    $("#content").text(data.body);
    $("#ccontent").text(data.body);
    $("#c-user").text(data.user[0].username);
    $("#d-article").text(data.title);
    $("#date").text(data.date_posted);
    $("#cdate").text(data.date_posted);

    loadComments(articleId, data.user[0].id);
  }).fail(function (xhr, status, error) {
    console.error(error);
  });
});

$("#delete-article-post").click(function () {
  var articleId = $("#d-newsId").val();
  $.post("delete", { id: articleId }, function (response) {
    alert("Article deleted!");
    window.location.reload();
  }).fail(function (xhr, status, error) {
    console.error(error);
  });
});

$(".create-article").click(function () {
  $("#news-title").val("");
  $("#news-body").val("");
});

$(".add-comment").click(function () {
  $("#comment-body").val("");
});
