<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <!-- Linking Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2>Update Contact</h2>
                </div>
                <div class="card-body">
                    <?php

                    require_once('db_connection.php');

                    // Check the connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Check if the contact ID is provided in the URL
                    if(isset($_GET['id'])){
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

                    ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $contact_id); ?>">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name:</label>
                            <input type="text" name="first_name" class="form-control" id="firstName" value="<?php echo $first_name ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name:</label>
                            <input type="text" name="last_name" class="form-control" id="lastName" value="<?php echo $last_name ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" name="email" class="form-control" id="email" value="<?php echo $email ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $phone ?? ''; ?>">
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Linking Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

</body>
</html>
