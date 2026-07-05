<?php
session_start();

if(!isset($_SESSION['user_id'])){
    exit();
}

$conn = mysqli_connect("mysql", "root", "root", "unipulse");

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT mood, log_date
    FROM user_moods
    WHERE user_id = ?
    ORDER BY log_date DESC
");

$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);