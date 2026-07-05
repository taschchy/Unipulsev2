<?php
session_start();
header('Content-Type: application/json');

// 1. Force Test Session if not set
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// 2. Connect to DB
$conn = mysqli_connect("mysql", "root", "root", "unipulse");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// 3. Read AJAX JSON Input data from frontend form submission
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['food_name']) && isset($data['calories'])) {
    $food_name = $data['food_name'];
    $calories = intval($data['calories']);

    // 4. Insert strictly using your table attributes: user_id, food_name, calories, log_date
    $stmt = $conn->prepare("INSERT INTO diet (user_id, food_name, calories, log_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $food_name, $calories, $today);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Missing food_name or calories parameters']);
}

$conn->close();
?>