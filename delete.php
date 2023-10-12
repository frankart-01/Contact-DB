<!DOCTYPE html>
<html>
<head>
    <title>Delete Contact</title>
    <link rel="stylesheet" href="inex.css">
</head>
<body>
    <?php
    // Define database connection parameters
    require_once('db_connection.php');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the contact ID is provided in the URL
    if (isset($_GET['id'])) {
        $contact_id = $_GET['id'];

        // Delete the contact from the database
        $delete_sql = "DELETE FROM contact_db WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $contact_id);

        if ($delete_stmt->execute()) {
            echo "Contact deleted successfully!";
        } else {
            echo "Error deleting contact: " . $delete_stmt->error;
        }

        // Close the statement
        $delete_stmt->close();
    } else {
        echo "Contact ID not provided.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
