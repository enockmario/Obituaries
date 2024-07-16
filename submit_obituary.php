<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_death = $_POST['date_of_death'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    // Generate a slug from the name
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "obituary_platform";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO obituaries (name, date_of_birth, date_of_death, content, author, slug) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $date_of_birth, $date_of_death, $content, $author, $slug);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New obituary submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
