<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete admin</title>
</head>
<body>

<?php
/* Validate and assign input data */
$id = ltrim(rtrim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT)));
if ((empty($id)) || (!filter_var($id, FILTER_VALIDATE_INT)))
{
    header("location: admin.php"); // deal with invalid input
    exit();
}


/* Include "configuration.php" file */
require_once "DbConnect.php";




/* Perform query */
$query = "Delete from admins WHERE id = :id";
$statement = $conn->prepare($query);
$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->execute();



/* Provide feedback that the record has been deleted */
if ($statement->rowCount() > 0)
{
    echo "<p>Admin successfully deleted.</p>";
}
else
{
    echo "<p>Admin does not exist, so it cannot be deleted.</p>";
}



/* Provide a link for the user to proceed to a new webpage or automatically redirect to a new webpage */
echo "<a href='admin.php'>Click here to delete another record</a>";
?>
</body>
</html>