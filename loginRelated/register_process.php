<?php

$username = $_POST['username'];
$password = $_POST['password'];
$full_name = $_POST['full_name'];
$major = $_POST['major'];
$year = $_POST['year'];
$conn = mysqli_connect("mysql", "root", "root", "unipulse");

$wellness_score = 2;

// jika mahu password lebih selamat
// $password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users
(username, password, full_name, major, year, wellness_score)
VALUES
('$username', '$password', '$full_name', '$major', '$year', '$wellness_score')";

if(mysqli_query($conn, $sql)){
    echo "<script>
            alert('Registration successful!');
            window.location='login.php';
          </script>";
}else{
    echo "<script>
            alert('Registration failed: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}