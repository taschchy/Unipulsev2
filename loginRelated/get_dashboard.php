<?php
session_start();

// 1. FOR TEST PURPOSES FIRST: Initialize session wrapper safely before processing validation guards
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2;
}

// 2. NOW evaluate authorization validation state safely
if(!isset($_SESSION['user_id'])){
    header('Content-Type: application/json');
    echo json_encode([
        "error"=>"Not logged in"
    ]);
    exit();
}
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$conn = mysqli_connect("mysql", "unipulse", "secret", "unipulse");
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// 1. Fetch User Profile
$user_stmt = $conn->prepare("SELECT full_name, major, year FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$userInfo = $user_stmt->get_result()->fetch_assoc();

// Store the full name in the session so the sidebar avatar initials work!
if ($userInfo && isset($userInfo['full_name'])) {
    $_SESSION['full_name'] = $userInfo['full_name'];
}

// 2. Fetch Mood
$mood_stmt = $conn->prepare("SELECT mood FROM user_moods WHERE user_id = ? AND log_date = ?");
$mood_stmt->bind_param("is", $user_id, $today);
$mood_stmt->execute();
$mood_res = $mood_stmt->get_result()->fetch_assoc();
$currentMood = $mood_res ? $mood_res['mood'] : 'Okay';

// 3. Fetch Water
$water_stmt = $conn->prepare("SELECT amount_liters FROM user_water WHERE user_id = ? AND log_date = ?");
$water_stmt->bind_param("is", $user_id, $today);
$water_stmt->execute();
$water_res = $water_stmt->get_result()->fetch_assoc();
$waterAmount = $water_res ? (float)$water_res['amount_liters'] : 0.0;

// 4. Fetch Meals (⚠️ FIXED: Adjusted column selections back to actual numeric attributes)
$meal_stmt = $conn->prepare("SELECT meals_eaten, total_meals FROM user_meals WHERE user_id = ? AND log_date = ?");
$meal_stmt->bind_param("is", $user_id, $today);
$meal_stmt->execute();
$meal_res = $meal_stmt->get_result()->fetch_assoc();
$mealsEaten = $meal_res ? (int)$meal_res['meals_eaten'] : 0;
$totalMeals = $meal_res ? (int)$meal_res['total_meals'] : 3;

// 5. Fetch Tasks
$tasks = [];
$tasks_stmt = $conn->prepare("SELECT id, name, status, tag FROM tasks WHERE user_id = ?");
if ($tasks_stmt) {
    $tasks_stmt->bind_param("i", $user_id);
    $tasks_stmt->execute();
    $tasks_result = $tasks_stmt->get_result();
    while ($row = $tasks_result->fetch_assoc()) {
        $tasks[] = $row;
    }
    $tasks_stmt->close();
}

// 6. Fetch Schedule
$schedule = [];
$sql = "SELECT * FROM schedule ORDER BY hour_slot ASC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $schedule[$row['hour_slot']] = [
        "type" => $row['type'],
        "name" => $row['name'],
        "sub"  => $row['sub_text']
    ];
}

// 7. Fetch Today's Dietary Logs Only
$dietLogs = [];
$nutritionCalories = 0;
$diet_stmt = $conn->prepare("SELECT food_name, calories, DATE_FORMAT(log_date, '%h:%i %p') as log_time FROM diet WHERE user_id = ? AND log_date = ? ORDER BY diet_id DESC");
if ($diet_stmt) {
    $diet_stmt->bind_param("is", $user_id, $today);
    $diet_stmt->execute();
    $diet_result = $diet_stmt->get_result();
    while ($row = $diet_result->fetch_assoc()) {
        $dietLogs[] = $row;
        $nutritionCalories += (int)$row['calories'];
    }
    $diet_stmt->close();
}

// Calculate Dynamic Live Wellness Score
$pendingTasks = array_filter($tasks, function($t) { return $t['status'] === 'pending'; });
$taskScore = count($tasks) > 0 ? ((count($tasks) - count($pendingTasks)) / count($tasks)) * 50 : 25;
$waterScore = min(($waterAmount / 3.0) * 25, 25);
$mealScore = $totalMeals > 0 ? min(($mealsEaten / $totalMeals) * 25, 25) : 0;
$wellnessScore = round($taskScore + $waterScore + $mealScore);

echo json_encode([
    "userInfo" => $userInfo,
    "currentMood" => $currentMood,
    "waterAmount" => $waterAmount,
    "mealsEaten" => $mealsEaten,
    "totalMeals" => $totalMeals,
    "wellnessScore" => $wellnessScore,
    "tasks" => $tasks,
    "schedule" => $schedule,
    "dietLogs" => $dietLogs,
    "nutritionCalories" => $nutritionCalories
]);

$conn->close();
?>