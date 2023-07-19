<?php
$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
  die("Connection Error: " . $mysqli->connect_errno);
}

// Get the updated values from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$productName = $data['productName'];
$productPrice = $data['productPrice'];
$district = $data['district'];
$state = $data['state'];

// Update the row in the database
$query = "UPDATE products SET productname = '$productName', productprice = '$productPrice', district = '$district', state = '$state' WHERE id = $id";

// Execute the query
if ($mysqli->query($query) === TRUE) {
  echo "Row updated successfully.";
} else {
  echo "Failed to update row: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
