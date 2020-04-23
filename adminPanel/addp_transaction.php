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
//$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
//if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
//{
//    header("location: addp.php"); // deal with invalid input
//    exit();
//}

$name = ltrim(rtrim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING)));
if (empty($name))
{
    header("location: addp.php"); // deal with invalid input
    exit();
}

$description = ltrim(rtrim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING)));
if (empty($description))
{
    header("location: addp.php"); // deal with invalid input
    exit();
}

$price = ltrim(rtrim(filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($price)) || (!filter_var($price, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: addp.php");
    exit();
}

$quantity = ltrim(rtrim(filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($quantity)) || (!filter_var($quantity, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: addp.php");
    exit();
}
$category = ltrim(rtrim(filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($category)) || (!filter_var($category, FILTER_VALIDATE_INT))) // deal with invalid input
{
    header("location: addp.php");
    exit();
}




/* Include "configuration.php" file */
require_once "DbConnect.php";

//if(isset($_POST['btnsave'])){
//    $imgFile = $_FILES['photo1']['name'];
//    $tmp_dir = $_FILES['photo1']['tmp_name'];
//    $imgSize = $_FILES['photo1']['size'];
//    $imgTmp =$_FILES['photo1']['tmp_name'];
//
//if(empty($imgFile)){
//    $errMSG = "Please Select Image File.";
//}
//else
//{
//    $upload_dir = 'user_images/'; // upload directory
//
//    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
//
//    // valid image extensions
//    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
//
//    // allow valid image file formats
//    if(in_array($imgExt, $valid_extensions)){
//        // Check file size '5MB'
//        if($imgSize < 5000000)    {
//        move_uploaded_file($imgTmp,"../../photo/".$imgFile);
//        }
//        else{
//            $errMSG = "Sorry, your file is too large.";
//        }
//    }
//    else{
//        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//    }
//}
//// if no error occured, continue ....
//  if(!isset($errMSG))
//  {
//        $statement = $conn->prepare("SELECT max(id) as maxid FROM announcement");
//        $statement->execute();
//        $announcement_id = $statement->fetchAll();
//        $number = $announcement_id[0]['maxid'];
//        $number=$number+1;
//
//   $stmt = $conn->prepare('INSERT INTO photo(path,position,product_id) VALUES(:name, 1, :number)');
//   //        $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 1, :id)";
//   $stmt->bindParam(':name',$imgFile);
//   $stmt->bindParam(':name',$number);
//
//   if($stmt->execute())
//   {
//    $successMSG = "new record succesfully inserted ...";
////    header("refresh:5;index.php"); // redirects image view page after 5 seconds.
//   }
//   else
//   {
//    $errMSG = "error while inserting....";
//   }
//  }
//// }
//}
$query = "INSERT INTO product (name,description,quantity,price,visible,category_id) VALUES (:name, :description, :quantity, :price, 1, :category)";
$statement = $conn->prepare($query);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":quantity", $quantity, PDO::PARAM_INT);
$statement->bindParam(":price", $price, PDO::PARAM_INT);
$statement->bindParam(":category", $category, PDO::PARAM_INT);
//$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->execute();

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

        $stmt = $conn->prepare("SELECT max(id) as maxid FROM product");
        $stmt->execute();
        $product_id = $stmt->fetchAll();
        $number = $product_id[0]['maxid'];
        $number=$number;


        echo $number;
        $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 1, :number)";
        $statement = $conn->prepare($query);
        $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
        $statement->bindParam(":number", $number, PDO::PARAM_INT);
        $statement->execute();
        move_uploaded_file($file_tmp,"../../photo/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}


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

        $stmt = $conn->prepare("SELECT max(id) as maxid FROM product");
        $stmt->execute();
        $product_id = $stmt->fetchAll();
        $number = $product_id[0]['maxid'];
        $number=$number;


        echo $number;
        $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 2, :number)";
        $statement = $conn->prepare($query);
        $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
        $statement->bindParam(":number", $number, PDO::PARAM_INT);
        $statement->execute();
        move_uploaded_file($file_tmp,"../../photo/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}


if (!empty($_FILES['photo3']['name'])){
    $errors= array();
    $file_name = $_FILES['photo3']['name'];
    $file_size =$_FILES['photo3']['size'];
    $file_tmp =$_FILES['photo3']['tmp_name'];
    $file_type=$_FILES['photo3']['type'];
    $file_ext = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 6097152){
        $errors[]='File size must be excately 6 MB';
    }

    if(empty($errors)==true){

        $stmt = $conn->prepare("SELECT max(id) as maxid FROM product");
        $stmt->execute();
        $product_id = $stmt->fetchAll();
        $number = $product_id[0]['maxid'];
        $number=$number;


        echo $number;
        $query = "INSERT INTO photo (path, position, product_id) VALUES (:name, 3, :number)";
        $statement = $conn->prepare($query);
        $statement->bindParam(":name", $file_name, PDO::PARAM_STR);
        $statement->bindParam(":number", $number, PDO::PARAM_INT);
        $statement->execute();
        move_uploaded_file($file_tmp,"../../photo/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}





/* Provide feedback that the record has been modified */
echo "<p>Record successfully modified.</p>";





/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
echo "<a href='http://13.80.137.25/android/adminPanel/products.php'>Update another record</a>";
?>
</body>
</html>