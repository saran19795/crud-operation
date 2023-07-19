<?php
$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
  die("Connection Error: " . $mysqli->connect_errno);
}

// Get the row ID from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$rowId = $data['id'];

// Delete the row from the database
$query = "DELETE FROM products WHERE id = $rowId";

// Execute the query
if ($mysqli->query($query) === TRUE) {
  echo "Row deleted successfully.";
} else {
  echo "Failed to delete row: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
