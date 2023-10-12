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
        
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="searchButton" type="button"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
            <small id="searchError" class="text-danger"></small>
        </div>

        <div id="results">
            <!-- Search results will be displayed here -->
        </div>

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

        // Close the database connection
        $conn->close();
        ?>
    </div>
    <script>
    function searchContacts() {
        const searchTerm = document.getElementById('searchInput').value;
        const searchError = document.getElementById('searchError');

        if (searchTerm.trim() === '') {
            searchError.textContent = 'Search term is required';
            document.getElementById('results').innerHTML = ''; // Clear results
            return;
        } else {
            searchError.textContent = '';
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'search.php?term=' + searchTerm, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('results').innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }

    document.getElementById('searchButton').addEventListener('click', searchContacts);
    document.getElementById('searchInput').addEventListener('input', searchContacts);
</script>

</body>
</html>
