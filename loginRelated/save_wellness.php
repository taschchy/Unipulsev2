<?php
session_start();
if(!isset($_SESSION['user_id'])){
    exit();
}
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2; // Safeguard developer fallback context
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['type'])) {
    echo json_encode(["status" => "error", "message" => "Parameter parameters dropped"]);
    exit();
}

$conn = mysqli_connect("mysql", "unipulse", "secret", "unipulse");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database link severed"]);
    exit();
}

$type = $input['type'];

// 1. Process Mood Changes
if ($type === 'mood') {
    $val = $input['value'];
    $stmt = $conn->prepare("INSERT INTO user_moods (user_id, mood, log_date)
                            VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE mood = ?");
    $stmt->bind_param("isss", $user_id, $val, $today, $val);
    $stmt->execute();
}

// 2. Process Water Volumetric Computations
if ($type === 'water') {
    $change = (float)$input['value'];
    $chk = $conn->prepare("SELECT amount_liters FROM user_water WHERE user_id = ? AND log_date = ?");
    $chk->bind_param("is", $user_id, $today);
    $chk->execute();
    $res = $chk->get_result()->fetch_assoc();
    $current = $res ? (float)$res['amount_liters'] : 0.0;

    $new_amount = max(0.0, $current + $change);
    $stmt = $conn->prepare("INSERT INTO user_water (user_id, amount_liters, log_date) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE amount_liters = ?");
    $stmt->bind_param("idsd", $user_id, $new_amount, $today, $new_amount);
    $stmt->execute();
}

// 3. Process Nutritional Meal Aggregations
if ($type === 'meals') {
    $change = (int)$input['value'];
    $chk = $conn->prepare("SELECT meals_eaten, total_meals FROM user_meals WHERE user_id = ? AND log_date = ?");
    $chk->bind_param("is", $user_id, $today);
    $chk->execute();
    $res = $chk->get_result()->fetch_assoc();
    $current = $res ? (int)$res['meals_eaten'] : 0;
    $total = $res ? (int)$res['total_meals'] : 3;

    $new_meals = max(0, min($current + $change, $total));
    $stmt = $conn->prepare("INSERT INTO user_meals (user_id, meals_eaten, total_meals, log_date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE meals_eaten = ?");
    $stmt->bind_param("iiisii", $user_id, $new_meals, $total, $today, $new_meals);
    $stmt->execute();
}

// 4. Process Task Checking Checkbox States
if ($type === 'toggle_task') {
    $task_id = (int)$input['id'];
    $status = $input['status'];
    $tag = ($status === 'done') ? 'Done' : 'Active';

    $stmt = $conn->prepare("UPDATE tasks SET status = ?, tag = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $status, $tag, $task_id, $user_id);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
$conn->close();
?>