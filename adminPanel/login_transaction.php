<?php
session_start();

// if it exists, then destroy any previous session
session_unset();
session_destroy();
session_start();

$response = array();
/* Validate and assign input data */
$username1 = ltrim(rtrim(filter_input(INPUT_POST, "username")));
if (empty($username1))
{
    header("location: index.php");
}

$password1 = ltrim(rtrim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)));
if (empty($password1))
{
    header("location: index.php"); // deal with invalid input
}

/* Connect to the database */
require_once "DbConnect.php";

/* Check that user is not already user_added  */
/*$statement = $conn->prepare("SELECT id,username FROM admins WHERE username = :username");
$statement->bindParam(":username", $username1, PDO::PARAM_STR);
$statement->execute();
echo $username1;
echo $password1;
$result=$statement->fetch(PDO::FETCH_OBJ);

if ($statement->rowCount() > 0)
{
    // set session user_id
    $_SESSION["id"] = $result->id;
    $_SESSION["username"] = $result->username;

}*/
$stmt = $conn->prepare("SELECT id,username,password FROM admins WHERE username = :username");
$stmt->bindParam(":username", $username1, PDO::PARAM_STR);
//                $stmt->bindParam(":password", $password, PDO::PARAM_STR);
$stmt->execute();
/*$stmt->store_result();*/
$count = $stmt->rowCount();
$user = $stmt->fetch(PDO::FETCH_OBJ);
if($count > 0) {
    //$stmt->bind_result($id, $username, $email, $gender);
    if (password_verify($password1, $user->password)) {
        $_SESSION["id"] = $user->id;
        $_SESSION["username"] = $user->username;
    }
}

// Go to password protected webpage.
// Note, if the $_SESSION["user_id"] has not been set in the "if" statement above, then the "home.php" file will redirect the user back to the login webpage
header("location: home.php");
?>