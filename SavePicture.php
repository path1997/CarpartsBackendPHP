<?php
require_once 'DbConnect.php';
$stmt = $conn->prepare("SELECT max(id) as maxid FROM announcement");
$stmt->execute();
$announcement_id = $stmt->fetchAll();
$number = $announcement_id[0]['maxid'];
$number=$number+1;

$image=$_POST['image'];
// Decode the Base64 encoded Image
$data = base64_decode($image);
// Create Image path with Image name and Extension
$file = '../photo/' . 'photo'. $number . '.jpg';
// Save Image in the Image Directory
$success = file_put_contents($file, $data);
?>