<?php 
session_start();

if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <?php if(isset($error)): ?>
                        <div><?= $error ?></div>
                    <?php endif; ?>
                    <div id="message" class="mt-3 text-danger"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#loginForm").submit(function(event) {
    event.preventDefault();
    
    var username = $("#username").val();
    var password = $("#password").val();

    $.post("login.php", { username: username, password: password }, function (response) {
    let parseData = JSON.parse(response);
    if (parseData.errors && parseData.errors.length > 0) {
        window.location.href = "index.php";
    } 
    else {
      window.location.href = "dashboard.php";
    }
  }).fail(function (xhr, status, error) {
    console.error(error);
  });

});
</script>

</body>
</html>
