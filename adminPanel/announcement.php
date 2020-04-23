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

    <title>Announcement</title>
</head>
<body>
<a class="btn btn-primary" href="home.php">Back</a>
<h1 class="text-center">Announcement</h1>
<?php
require_once 'DbConnect.php';
/*echo("<button class='btn btn-primary' onclick=\"location.href='adda.php'\">Add product</button>");*/

    $statement = $conn->prepare("SELECT id,title,description,price,endannouncement from announcement");
    $statement->execute();

    //$products_list = $statement->fetchAll(PDO::FETCH_OBJ);
    /*$response['cos']=$products_list;
    echo json_encode($response);*/
    if ($statement->rowCount() > 0) {
        echo "<div class='col-md-10 mt-2'>";
        echo "<table class='table table-striped table-bordered table-dark'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Id</th>";
        echo "<th scope='col'>Title</th>";
        echo "<th scope='col'>Description</th>";
        echo "<th scope='col'>Price</th>";
        echo "<th scope='col'>Endannouncement</th>";
        echo "<th scope='col'>Options</th>";
        echo "</tr>";
        echo "</thead>";

        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row->id . "</td><td>" . $row->title . "</td><td>" . $row->description . "</td><td>" . $row->price . "</td><td>" . $row->endannouncement . "</td><td>" ."<form class='mx-2' action='updatea.php' style='display: inline-block;' method='post'>
    <input type='hidden' value='$row->id' id = 'id' name = 'id' required>
    <input type='submit' class='btn btn-primary' value='Edit'>
</form>".
                "<form action='deletea_transaction.php' style='display: inline-block;' method='post'>
    <input type='hidden' value='$row->id' id = 'id' name = 'id' required>
    <input type='submit' class='btn btn-primary' value='Delete'>
</form>". "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

}
echo "</div>";







?>
</body>
</html>