<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update announcement</title>
</head>
<body>

<?php
/* Validate and assign input data */
$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
{
    header("location: updatea.php"); // deal with invalid input
    exit();
}

$title = ltrim(rtrim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING)));
if (empty($title))
{
    header("location: updatea.php"); // deal with invalid input
    exit();
}

$description = ltrim(rtrim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING)));
if (empty($description))
{
    header("location: updatea.php"); // deal with invalid input
    exit();
}


$price = ltrim(rtrim(filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($price)) || (!filter_var($price, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: updatea.php");
    exit();
}



/* Include "configuration.php" file */
require_once "DbConnect.php";

if (!empty($_FILES['photo']['name'])){
    $errors= array();
    $file_name = $_FILES['photo']['name'];
    $file_size =$_FILES['photo']['size'];
    $file_tmp =$_FILES['photo']['tmp_name'];
    $file_type=$_FILES['photo']['type'];
    $file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 6097152){
        $errors[]='File size must be excately 6 MB';
    }

    if(empty($errors)==true){
        $query = "SELECT id,path FROM announcement WHERE id=:id";
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
        $nn="photo".$result['id'].".jpg";
        $query = "UPDATE announcement SET path= :name where id= :id";
        $statement = $conn->prepare($query);
        $statement->bindParam(":name", $nn, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        move_uploaded_file($file_tmp,"../../photo/photo".$result['id'].".jpg");
        echo "Success";
    }else{
        print_r($errors);
    }
}


/* Perform query */
$query = "UPDATE announcement SET title = :title, description = :description, price = :price WHERE id = :id";
$statement = $conn->prepare($query);
$statement->bindParam(":title", $title, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":price", $price, PDO::PARAM_INT);
$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->execute();



/* Provide feedback that the record has been modified */

echo "<p>Record successfully modified.</p>";




/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
echo "<a href='http://13.80.137.25/android/adminPanel/announcement.php'>Update another record</a>";
?>
</body>
</html>