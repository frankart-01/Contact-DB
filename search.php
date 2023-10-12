<?php
require_once('db_connection.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search term from the URL
$searchTerm = $_GET['term'];

if (empty($searchTerm)) {
    echo '<div class="alert alert-danger">Search term is required.</div>';
} else {
    // Create the SQL query to search for contacts by name or email
    $sql = "SELECT * FROM contact_db WHERE first_name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead class="thead-dark"><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["first_name"] . '</td>';
            echo '<td>' . $row["last_name"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["phone"] . '</td>';
            echo '<td>';
            echo '<a class="btn btn-primary" href="update.php?id=' . $row["id"] . '"><i class="fas fa-edit"></i> Update</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="delete.php?id=' . $row["id"] . '"><i class="fas fa-trash-alt"></i> Delete</a>';
            echo '</td>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<div class="alert alert-info">No contacts found.</div>';
    }
}

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
// Close the database connection
$conn->close();
?>