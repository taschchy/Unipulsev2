<?php
session_start();

// 1. Connect to the XAMPP MySQL Database
$conn = mysqli_connect("mysql", "root", "root", "unipulse");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 2. Capture the user input safely
$user = $_POST['username'];
$pass = $_POST['password'];

// 3. Search for the user in the database
// We use a prepared statement to prevent SQL injection hacks!
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 4. Verify password (checks both plain text or hashed encryption)
    if (password_verify($pass, $row['password']) || $pass === $row['password']) {

        // SUCCESS: Hand the user their session security wristband!
        $_SESSION['user_id'] = $row['id'];

        // Send them directly to your dashboard
        header("Location: ../dashboard.php");
exit();
    }
}

// FAILURE: Send them back to the login page with an error flag
header("Location: ../login.php?error=1");
exit();
?>