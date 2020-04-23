<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Add admin</title>

</head>

<body>
<div class="row mx-4">
    <div class="col-md-4">
        <form action="addadmin_transaction.php" method="post" >
            <input type="hidden" id = "id" name = "id" required>
            <div class="form-group">
                <label for="username">Username: </label>
                <input class="form-control" type="username" id = "username" name = "username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input class="form-control" type="password" id = "password" name = "password" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Add admin">
    </form>
</div>
<div class="col-md-1">
</div>




</body>
</html>