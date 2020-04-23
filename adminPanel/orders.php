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

    <title>Orders</title>
</head>
<body>
<a class="btn btn-primary" href="home.php">Back</a>
<h1 class="text-center mb-5">Orders</h1>
<?php
require_once 'DbConnect.php';

$statement = $conn->prepare("SELECT o.id,o.date_of_order,u.fname,u.sname,u.email,u.phone,u.postcode,u.city,u.address,o.totalcost from orders o, users u where o.user_id=u.id order by o.id desc");
$statement->execute();

//$products_list = $statement->fetchAll(PDO::FETCH_OBJ);
/*$response['cos']=$products_list;
echo json_encode($response);*/

echo "<div class='row mt-5 mx-5'>";
echo "<div class='col-md-5 text-center'>";
echo "<p class='h2'>Client</p>";
echo "</div>";
echo "<div class='vl' style='border-left: 4px solid black'></div>";
echo "<div class='col-md-4 text-center'>";
echo "<p class='h2'>Products</p>";
echo "</div>";
echo "</div>";
echo "<div class='row mx-5'>";
echo "<div class='col-md-12'>";
echo "<hr style='border-top: 4px solid black;'>";
echo "</div>";
echo "</div>";

$result = $statement->fetchAll(PDO::FETCH_OBJ);
foreach ($result as $row) {

    echo "<div class='row mx-5'>";
    echo "<div class='col-md-2 text-center'>";
    echo "<p class='h4'>Order number: ".$row->id."</p>";
    echo "</div>";
    echo "<div class='col-md-3 text-right'>";

    echo "<p>First and second name: ".$row->fname." ".$row->sname."</p>";
    echo "<p>Phone: ".$row->phone."</p>";
    echo "<p>Email: ".$row->email."</p>";
    echo "<p>Address: ".$row->postcode." ".$row->city." ".$row->address."</p>";
    echo "<p>Total order cost: ".$row->totalcost."</p>";

    echo "</div>";
    echo "<div class='vl' style='border-left: 4px solid black'></div>";
    echo "<div class='col-md-4'>";
    $statement = $conn->prepare("SELECT p.name, c.quantity from product p, cart c where c.product_id=p.id and c.orders_id= :id");
    $statement->bindParam(":id", $row->id, PDO::PARAM_STR);
    $statement->execute();
    $result1 = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($result1 as $row1) {
        echo "<p>".$row1->quantity."x".$row1->name;
    }
    //echo "<hr>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row mx-5'>";
    echo "<div class='col-md-12'>";
    echo "<hr style='border-top: 4px solid black;'>";
    echo "</div>";
    echo "</div>";
}

?>
</body>
</html>