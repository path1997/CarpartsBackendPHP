<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it 
$servername = "sql1.5v.pl";
$username = "patcher1997_carparts";
$password = "zaq1@WSX";
$database = "patcher1997_carparts";
 
 
//creating a new connection object using mysqli 
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error 
