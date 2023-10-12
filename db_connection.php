<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection</title>
     <!-- Include Bootstrap CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include your custom CSS file (style.css) if you have one -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = null;
$database = "contact_db";


// Create a database connection
// $conn = new mysqli($host, $username, $password, $database);
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

</body>
</html>