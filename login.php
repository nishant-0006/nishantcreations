<?php
// Database connection
$servername = "127.0.0.1";  // Your server address
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "test";           // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume these come from the login form input (e.g., POST request)
$formUsername = $_POST['username'];
$formPassword = $_POST['password'];

// Prepare and execute query to find the user by username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $formUsername);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists and verify password
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Verify the password with password_verify()
    if (password_verify($formPassword, $user['password'])) {
        echo "Login successful!";
        // Add session handling or redirection to the user dashboard
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
