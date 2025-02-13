<?php
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$confirmpassword=$_POST['confirm password'];

//Database connection
if(empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
    die("All fields are required.");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

if($password !== $confirmpassword) {
    die("Passwords do not match.");
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');

if($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT id FROM pharmacistloginform(2) WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0) {
        die("Username or Email already exists.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO pharmacistloginform(2) (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();

    echo "Registration successful!";
    $stmt->close();
    $conn->close();
}
?>