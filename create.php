<?php
// Include the database connection script
require_once('db_connection.php');

// Check if the database is empty
$sql = "SELECT COUNT(*) as count FROM contact_db";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
    
    if ($count == 0) {
        // If the database is empty, set the ID to 1
        $contact_id = 1;
    } else {
        // If there are existing records, get the maximum ID and increment it
        $sql = "SELECT MAX(id) as max_id FROM contact_db";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $max_id = $row['max_id'];
            
            // Increment the maximum ID to assign a new ID
            $contact_id = $max_id + 1;
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Error: " . $conn->error;
}

// Define variables to store form data
$first_name = $last_name = $email = $phone = "";
$first_name_err = $last_name_err = $email_err = $phone_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    // Validate first name
    if (empty($first_name)) {
        $first_name_err = "Please enter a first name.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
        $first_name_err = "Only letters, hyphens, and spaces allowed.";
    }

    // Validate last name
    if (empty($last_name)) {
        $last_name_err = "Please enter a last name.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
        $last_name_err = "Only letters, hyphens, and spaces allowed.";
    }

    // Validate email
    if (empty($email)) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    }

    // Validate phone number (you can customize this validation)
    if (empty($phone)) {
        $phone_err = "Please enter a phone number.";
    }

    // If there are no errors, insert the contact into the database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($phone_err)) {
        $sql = "INSERT INTO contact_db (id, first_name, last_name, email, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $contact_id, $first_name, $last_name, $email, $phone);

        if ($stmt->execute()) {
            // Contact added successfully
            header("Location: index.php"); // Redirect to the contact list page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Create Contact
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                                <span class="text-danger"><?php echo $first_name_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                                <span class="text-danger"><?php echo $last_name_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                <span class="text-danger"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                                <span class="text-danger"><?php echo $phone_err; ?></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
