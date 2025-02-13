<?php
// Database configuration
$servername = "localhost";  // Usually 'localhost' for local server
$username = "root";         // Default username for MySQL in XAMPP or WAMP is empty
$password = "";             // Default password for MySQL in XAMPP or WAMP is empty
$dbname = "pharmacistsignupform"; // The database name you created earlier

// Create a connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database!";
}

// Include the database connection file
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the data into the signupform table
    $sql = "INSERT INTO signupform (username, email, password, confirm_password) 
            VALUES ('$username', '$email', '$hashed_password', '$confirm_password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>