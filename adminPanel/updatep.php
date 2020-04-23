<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Update product</title>
</head>

<body>
<a class="btn btn-primary" href="products.php">Back</a>
<?php
require_once 'DbConnect.php';
$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
{
    header("location: announcement.php"); // deal with invalid input
    exit();
}
$statement = $conn->prepare("SELECT id,name,description,price,quantity from product where id=:id");
$statement->bindParam(":id", $id, PDO::PARAM_STR);
$statement->execute();
$product = $statement->fetchAll(PDO::FETCH_OBJ);
foreach ($product as $row) {

    echo "<div class='row mx-4'>";
    echo "<div class='col-md-4'>";
    echo "<form action='updatep_transaction.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' id = 'id' name = 'id' value='$id' required>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Name: </label>";
    echo "<input class='form-control' type='name' id = 'name' name = 'name' value='$row->name' required autofocus>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='description'>Description: </label>";
    echo "<textarea class='form-control' id='description' name='description' rows='3'>$row->description</textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='price'>Price: </label>";
    echo "<input class='form-control' type='number' id = 'price' value='$row->price' name = 'price'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='quantity'>Quantity: </label>";
    echo "<input class='form-control' type='number' id = 'quantity' value='$row->quantity' name = 'quantity' required>";
    echo "</div>";
    echo "<input type='submit' class='btn btn-primary' value='Update Record'>";

    echo "</div>";
    echo "<div class='col-md-1'>";
    echo "</div>";

}
$statement = $conn->prepare("SELECT path,position from photo where product_id=:id order by position");
$statement->bindParam(":id", $id, PDO::PARAM_STR);
$statement->execute();
$product = $statement->fetchAll(PDO::FETCH_OBJ);
$x=0;
$y=0;

    echo "<div class='col-md-2 mt-4'>";
    echo "<label>Photo 1</label><br>";
    foreach ($product as $row) {
    if($row->position==1) {
        echo "<img src='http://13.80.137.25/photo/$row->path' width='160' height='90'>";
    }
    }
    echo "<div class='form-group'>";
    echo "<input type='file' name='photo1'>";
    //echo "<label><input type='checkbox' name='usun1' id='usun1'>Usuń</label>";
    echo "</div>";
    echo "</div>";

    echo "<div class='col-md-2 mt-4'>";
    echo "<label>Photo 2</label><br>";
    foreach ($product as $row) {
    if($row->position==2) {
        echo "<img src='http://13.80.137.25/photo/$row->path' width='160' height='90'>";
        $x++;
    }
    }
    echo "<div class='form-group'>";
    echo "<input type='file' name='photo2'>";
    if($x!=0) {
        echo "<label><input type='checkbox' name='usun2' id='usun2'>Usuń</label>";
    }
    echo "</div>";
    echo "</div>";

    echo "<div class='col-md-2 mt-4'>";
    echo "<label>Photo 3</label><br>";
    foreach ($product as $row) {
        if($row->position==3) {
            echo "<img src='http://13.80.137.25/photo/$row->path' width='160' height='90'>";
            $y++;
        }
    }
    echo "<div class='form-group'>";
    echo "<input type='file' name='photo3'>";
    if($y!=0) {
        echo "<label><input type='checkbox' name='usun3' id='usun3'>Usuń</label>";
    }
    echo "</div>";
    echo "</div>";
    echo "</form>";

echo "</div>";
?>


</body>
</html>