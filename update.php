<!DOCTYPE html>
<html>
<head>
    <title>Update Contact</title>
</head>
<body>
    <?php

    require_once('db_connection.php');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the contact ID is provided in the URL
    if (isset($_GET['id'])) {
        $contact_id = $_GET['id'];

        // Retrieve contact information based on the contact ID
        $sql = "SELECT * FROM contact_db WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contact_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $phone = $row['phone'];

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve updated data from the form
                $new_first_name = $_POST['first_name'];
                $new_last_name = $_POST['last_name'];
                $new_email = $_POST['email'];
                $new_phone = $_POST['phone'];

                // Update the contact in the database
                $update_sql = "UPDATE contact_db SET first_name=?, last_name=?, email=?, phone=? WHERE id=?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ssssi", $new_first_name, $new_last_name, $new_email, $new_phone, $contact_id);

                if ($update_stmt->execute()) {
                    echo "Contact updated successfully!";
                } else {
                    echo "Error updating contact: " . $update_stmt->error;
                }
            }
        } else {
            echo "Contact not found.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Contact ID not provided.";
    }

    // Close the database connection
    $conn->close();
    ?>

    <h2>Update Contact</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $contact_id); ?>">
        First Name: <input type="text" name="first_name" value=""<?php echo $first_name=""; ?>"><br><br>
        Last Name: <input type="text" name="last_name" value=""<?php echo $last_name=""; ?>"><br><br>
        Email: <input type="text" name="email" value=""<?php echo $email=""; ?>"><br><br>
        Phone: <input type="text" name="phone" value=""<?php echo $phone=""; ?>"><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
