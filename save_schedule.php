<?php
header('Content-Type: application/json');
session_start();

$conn = mysqli_connect("mysql", "root", "root", "unipulse");

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => $conn->connect_error
    ]));
}

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id']; // atau ikut sistem login anda
$hour_slot = $data['hour'];
$type = $data['type'];
$name = $data['name'];
$sub_text = $data['sub'];

$stmt = $conn->prepare("
    INSERT INTO schedule
    (user_id, hour_slot, type, name, sub_text)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issss",
    $user_id,
    $hour_slot,
    $type,
    $name,
    $sub_text
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();