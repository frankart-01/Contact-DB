<!DOCTYPE html>
<html>
<head>
    <title>Contacts List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">

</head>
<body>
    <div class="container mt-5">
        <h2>Contacts List</h2>

        <?php
        require_once('db_connection.php');

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve contacts from the database
        $sql = "SELECT * FROM contact_db";
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

                // Add links for update and delete operations
                echo '<td>';
                echo '<a class="btn btn-primary" href="update2.php?id=' . $row["id"] . '"><i class="fas fa-edit"></i> Update</a>';
                echo ' ';
                echo '<a class="btn btn-danger" href="delete2.php?id=' . $row["id"] . '"><i class="fas fa-trash-alt"></i> Delete</a>';
                echo '</td>';
                
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info">No contacts found.</div>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
