<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add admin</title>
</head>
<body>

<?php

require_once "DbConnect.php";
$username = ltrim(rtrim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)));
if (empty($username))
{
    header("location: addadmin.php"); // deal with invalid input
    exit();
}


$password = password_hash($_POST['password'],PASSWORD_BCRYPT);
if (empty($password))
{
    header("location: addadmin.php"); // deal with invalid input
    exit();
}
$stmt = $conn->prepare("SELECT id FROM admins WHERE username = :username");
$stmt->bindParam(":username", $username, PDO::PARAM_STR);
$stmt->execute();
/*$stmt->store_result();*/
$count = $stmt->rowCount();
if ($count > 0) {
    header("location: addadmin.php"); // deal with invalid input
    exit();
}

$query = "INSERT INTO admins (username, password) VALUES ( :username , :password)";
$statement = $conn->prepare($query);
$statement->bindParam(":username", $username, PDO::PARAM_STR);
$statement->bindParam(":password", $password, PDO::PARAM_STR);
$statement->execute();

echo "<p>Add admin successful</p>";





/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
echo "<a href='http://13.80.137.25/android/adminPanel/admin.php'>Admin list</a>";
?>
</body>
</html>