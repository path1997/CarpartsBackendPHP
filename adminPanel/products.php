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

    <title>Products</title>
</head>
<body>
<a class="btn btn-primary" href="home.php">Back</a>
<h1 class="text-center">Products</h1>
<?php
    require_once 'DbConnect.php';
    $stmt = $conn->prepare("SELECT name,id FROM category");
    $stmt->execute();
    $category = $stmt->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    echo("<button class='btn btn-primary' onclick=\"location.href='addp.php'\">Add product</button>");
    foreach ($category as $row1) {
        $i++;
        echo "<div class='accordion' id='accordionExample'>";
        echo "<div class='card'>";
        echo "<div class='card-header' id='$row1->name.$row1->id'>";
        echo "<h2 class='mb-0'>";
        if($i==1) {
            echo "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#$row1->name' aria-expanded='true' aria-controls='$row1->name'>";
        } else {
            echo "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#$row1->name' aria-expanded='false' aria-controls='$row1->name'>";

        }
        echo "$row1->name";
        echo "</button>";
        echo "</h2>";
        echo "</div>";
        if($i==1) {
            echo "<div id='$row1->name' class='collapse show' aria-labelledby='$row1->name.$row1->id' data-parent='#accordionExample'>";
        } else {
            echo "<div id='$row1->name' class='collapse' aria-labelledby='$row1->name.$row1->id' data-parent='#accordionExample'>";
        }
        echo "<div class='card-body'>";
        $statement = $conn->prepare("SELECT p.id,p.name,p.price,p.description,p.quantity FROM product p where category_id= :categoryida and visible=1");
        $statement->bindParam(":categoryida", $row1->id, PDO::PARAM_STR);
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
            echo "<th scope='col'>Name</th>";
            echo "<th scope='col'>Description</th>";
            echo "<th scope='col'>Price</th>";
            echo "<th scope='col'>Quantity</th>";
            echo "<th scope='col'>Options</th>";
            echo "</tr>";
            echo "</thead>";

            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row->id . "</td><td>" . $row->name . "</td><td>" . $row->description . "</td><td>" . $row->price . "</td><td>" . $row->quantity . "</td><td>" ."<form class='mx-2' action='updatep.php' style='display: inline-block;' method='post'>
    <input type='hidden' value='$row->id' id = 'id' name = 'id' required>
    <input type='submit' class='btn btn-primary' value='Edit'>
</form>". "<form action='deletep_transaction.php' style='display: inline-block;' method='post'>
    <input type='hidden' value='$row->id' id = 'id' name = 'id' required>
    <input type='submit' class='btn btn-primary' value='Delete'>
</form>". "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";







    ?>
</body>
</html>