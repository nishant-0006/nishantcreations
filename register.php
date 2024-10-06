<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root"; // Update to your MySQL username
$password = ""; // Update to your MySQL password
$dbname = "test"; // Database name

// Create connection
$conn = new mysqli($servername, $db_username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $db_username = mysqli_real_escape_string($conn, $_POST['Username']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['Confirm_Password']);

    
    // Check if passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }
    
    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the users table
    $sql = "INSERT INTO users (username, email, password) VALUES ('$db_username', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Redirect to login page
        header("Location: registsucc.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
