<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Update announcement</title>

</head>
<body>
<a class="btn btn-primary" href="announcement.php">Back</a>
<?php
require_once 'DbConnect.php';
$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
{
    header("location: announcement.php"); // deal with invalid input
    exit();
}
$statement = $conn->prepare("SELECT id,title,description,price,endannouncement,path from announcement where id=:id");
$statement->bindParam(":id", $id, PDO::PARAM_STR);
$statement->execute();
$announcement = $statement->fetchAll(PDO::FETCH_OBJ);
foreach ($announcement as $row) {
    echo "<div class='row mx-4'>";
    echo "<div class='col-md-4'>";
    echo "<form action='updatea_transaction.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' id = 'id' name = 'id' value='$id' required>";
    echo "<div class='form-group'>";
    echo "<label for='title'>Title: </label>";
    echo "<input class='form-control' type='name' id = 'title' name = 'title' value='$row->title' required autofocus>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='description'>Description: </label>";
    echo "<textarea class='form-control' id='description' name='description' rows='3'>$row->description</textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='price'>Price: </label>";
    echo "<input class='form-control' type='number' id = 'price' name = 'price' value='$row->price'>";
    echo "</div>";
    echo "<input type='submit' class='btn btn-primary' value='Update Record'>";
    echo "</div>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-4 mt-4'>";
    echo "<label>Photo</label><br>";
    echo "<img src='http://13.80.137.25/photo/$row->path' width='320' height='180'>";
    echo "<div class='form-group'>";
    echo "<input type='file' name='photo'>";
    echo "</div>";
    echo "</form>";
    echo "</div>";

    echo "</div>";
}
?>

</body>
</html>