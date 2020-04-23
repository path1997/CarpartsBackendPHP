<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>Login to admin panel</title>
</head>

<body>

<div class="row">
    <div class="col-md-4 mx-4 my-4 text-white bg-dark rounded px-4 py-4">
        <h2 class="mx-4 mt-4">Login to admin panel</h2>
<form action="login_transaction.php" method="post">

    <!--<div class="form-group">-->
    <label for="username">Username: </label>
    <input type="text" class="form-control" id = "username" name = "username" placeholder = "Enter your username" required><br>
   <!-- </div>
    <div class="form-group">-->
    <label for="password">Password: </label>
    <input type="password" class="form-control" id = "password" name = "password" placeholder = "Enter your password" required><br>
    <!--</div>-->
    <input type="submit" class="btn btn-primary" value="Login"><br>

</form>
    </div>
</div>

</body>
</html>