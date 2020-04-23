<?php
session_start();
if (!isset($_SESSION["id"]))
{
    //echo $_SESSION["id"];
    header("location: index.php");
    exit();
}
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

    <title>Admin panel</title>
</head>
<body>
<a class="btn btn-primary" href="logout.php">Logout</a>
<h1 class="text-center">Admin panel</h1>

<div class="row mt-4">
    <div class="col-md-3 text-center">
        <a href="products.php" style="text-decoration: none"><h2>Products</h2></a>
        <a href="products.php"><img src="product_icon.png" width="200" height="200"></a>
    </div>
    <div class="col-md-3 text-center">
        <a href="announcement.php" style="text-decoration: none"><h2>Announcement</h2></a>
        <a href="announcement.php"><img src="ad_icon.png"width="200" height="200"></a>
    </div>
    <div class="col-md-3 text-center">
        <a href="orders.php" style="text-decoration: none"><h2>Orders</h2></a>
        <a href="orders.php"><img src="order_icon.png"width="200" height="200"></a>
    </div>
    <?php if($_SESSION["id"]=="1"){
    echo "<div class='col-md-3 text-center'>";
        echo "<a href='admin.php' style='text-decoration: none'><h2>Admins</h2></a>";
        echo "<a href='admin.php'><img src='admin_icon.png'width='200' height='200'></a>";
    echo "</div>";
    }
    ?>
</div>

<!--<a href="announcement.php">Announcement </a>-->
</body>
</html>