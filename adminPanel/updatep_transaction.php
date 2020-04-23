<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update product</title>
</head>
<body>

<?php
/* Validate and assign input data */
$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
{
    header("location: updatep.php"); // deal with invalid input
    exit();
}

$name = ltrim(rtrim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING)));
if (empty($name))
{
    header("location: updatep.php"); // deal with invalid input
    exit();
}

$description = ltrim(rtrim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING)));
if (empty($description))
{
    header("location: updatep.php"); // deal with invalid input
    exit();
}

$quantity = ltrim(rtrim(filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($quantity)) || (!filter_var($quantity, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: updatep.php");
    exit();
}

$price = ltrim(rtrim(filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($price)) || (!filter_var($price, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: updatep.php");
    exit();
}



/* Include "configuration.php" file */
require_once "DbConnect.php";

if (!empty($_FILES['photo1']['name'])){
    $errors= array();
    $file_name = $_FILES['photo1']['name'];
    $file_size =$_FILES['photo1']['size'];
    $file_tmp =$_FILES['photo1']['tmp_name'];
    $file_type=$_FILES['photo1']['type'];
    $file_ext = pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 6097152){
        $errors[]='File size must be excately 6 MB';
    }

    if(empty($errors)==true){
        $query = "SELECT path FROM photo WHERE position=1 and product_id=:id";
        $statement = $conn->prepare($query);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        //print_r($result['path']);
        $path = "images";
        $filename =  "../../photo/" . $result['path'];
        if (file_exists($filename)) {
            unlink($filename);
        } else {
            echo 'Could not delete ' . $filename . ', file does not exist';
        }
        $query = "DELETE FROM photo WHERE position=1 and product_id=:id";
        $statement = $conn->prepare($query);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 1, :id)";
        $statement = $conn->prepare($query);
        $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        move_uploaded_file($file_tmp,"../../photo/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}
if (isset($_POST['usun2'])){
    $query = "SELECT path FROM photo WHERE position=2 and product_id=:id";
    $statement = $conn->prepare($query);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    //print_r($result['path']);
    $path = "images";
    $filename =  "../../photo/" . $result['path'];
    if (file_exists($filename)) {
        unlink($filename);
    } else {
        echo 'Could not delete ' . $filename . ', file does not exist';
    }
    $query = "DELETE FROM photo WHERE position=2 and product_id=:id";
    $statement = $conn->prepare($query);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->execute();

} else {
    if (!empty($_FILES['photo2']['name'])){
        $errors= array();
        $file_name = $_FILES['photo2']['name'];
        $file_size =$_FILES['photo2']['size'];
        $file_tmp =$_FILES['photo2']['tmp_name'];
        $file_type=$_FILES['photo2']['type'];
        $file_ext = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);

        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 6097152){
            $errors[]='File size must be excately 6 MB';
        }

        if(empty($errors)==true){
            $query = "SELECT path FROM photo WHERE position=2 and product_id=:id";
            $statement = $conn->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();
            if($result['path']!=NULL) {
                //print_r($result['path']);
                $path = "images";
                $filename = "../../photo/" . $result['path'];
                if (file_exists($filename)) {
                    unlink($filename);
                } else {
                    echo 'Could not delete ' . $filename . ', file does not exist';
                }
                $query = "DELETE FROM photo WHERE position=2 and product_id=:id";
                $statement = $conn->prepare($query);
                $statement->bindParam(":id", $id, PDO::PARAM_INT);
                $statement->execute();
            }
            $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 2, :id)";
            $statement = $conn->prepare($query);
            $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            move_uploaded_file($file_tmp,"../../photo/".$file_name);
            echo "Success";
        }else{
            print_r($errors);
        }
    } 
}
if (isset($_POST['usun3'])){
    $query = "SELECT path FROM photo WHERE position=3 and product_id=:id";
    $statement = $conn->prepare($query);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    //print_r($result['path']);
    $path = "images";
    $filename =  "../../photo/" . $result['path'];
    if (file_exists($filename)) {
        unlink($filename);
    } else {
        echo 'Could not delete ' . $filename . ', file does not exist';
    }
    $query = "DELETE FROM photo WHERE position=3 and product_id=:id";
    $statement = $conn->prepare($query);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->execute();
} else {
    if (!empty($_FILES['photo3']['name'])){
        $errors= array();
        $file_name = $_FILES['photo3']['name'];
        $file_size =$_FILES['photo3']['size'];
        $file_tmp =$_FILES['photo3']['tmp_name'];
        $file_type=$_FILES['photo3']['type'];
        $file_ext = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
        //echo $file_ext;
        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 6097152){
            $errors[]='File size must be excately 6 MB';
        }

        if(empty($errors)==true){
            $query = "SELECT path FROM photo WHERE position=3 and product_id=:id";
            $statement = $conn->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();
            //print_r($result['path']);
            if($result['path']!=NULL) {
                $path = "images";
                $filename = "../../photo/" . $result['path'];
                if (file_exists($filename)) {
                    unlink($filename);
                } else {
                    echo 'Could not delete ' . $filename . ', file does not exist';
                }
                $query = "DELETE FROM photo WHERE position=3 and product_id=:id";
                $statement = $conn->prepare($query);
                $statement->bindParam(":id", $id, PDO::PARAM_INT);
                $statement->execute();
            }
            $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 3, :id)";
            $statement = $conn->prepare($query);
            $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            move_uploaded_file($file_tmp,"../../photo/".$file_name);
            //echo "Success";
        }else{
            print_r($errors);
        }
    }
}


/* Perform query */
$query = "UPDATE product SET name = :name, description = :description, quantity = :quantity, price = :price WHERE id = :id";
$statement = $conn->prepare($query);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":quantity", $quantity, PDO::PARAM_INT);
$statement->bindParam(":price", $price, PDO::PARAM_INT);
$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->execute();



/* Provide feedback that the record has been modified */
echo "<p>Record successfully modified.</p>";





/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
echo "<a href='http://13.80.137.25/android/adminPanel/products.php'>Update another record</a>";
?>
</body>
</html>