<?php
session_start();

// For testing only
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Database connection
$conn = mysqli_connect("mysql", "unipulse", "secret", "unipulse");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$success_message = "";
$error_message = "";

// ===========================
// SAVE FOOD
// ===========================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_food'])) {

    $food_name = trim($_POST['food_name']);
    $calories = intval($_POST['calories']);

    if (!empty($food_name) && $calories > 0) {

        $stmt = $conn->prepare("
            INSERT INTO user_meals
            (user_id, meal_name, meal_calories, log_date)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isis",
            $user_id,
            $food_name,
            $calories,
            $today
        );

        if ($stmt->execute()) {
            $success_message = "Food entry successfully saved! 🌸";
        } else {
            $error_message = "Database Error: " . $stmt->error;
        }

        $stmt->close();

    } else {

        $error_message = "Please enter a valid meal and calories.";

    }
}

// ===========================
// LOAD TODAY'S HISTORY
// ===========================
$dietLogs = [];
$totalCaloriesToday = 0;

$history_stmt = $conn->prepare("
SELECT
meal_name,
meal_calories,
log_date
FROM user_meals
WHERE user_id = ?
AND log_date = ?
ORDER BY id DESC
");

$history_stmt->bind_param("is", $user_id, $today);
$history_stmt->execute();

$result = $history_stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $dietLogs[] = $row;
    $totalCaloriesToday += (int)$row['meal_calories'];

}

$history_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>UNIPULSE — Dietary Manager</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*,
*::before,
*::after{
box-sizing:border-box;
margin:0;
padding:0;
}

body{

font-family:'Poppins',sans-serif;
background:#f4f5f6;
padding:2rem;
color:#1e293b;

}

.container{

max-width:1000px;
margin:auto;

}

.header{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:2rem;

}

.wordmark{

font-family:'Fredoka',sans-serif;
font-size:24px;
font-weight:700;
text-decoration:none;
color:#94a3b8;

}

.wordmark b{

color:#7c3aed;

}

.back-btn{

text-decoration:none;
display:flex;
align-items:center;
gap:6px;
font-size:13px;
font-weight:600;
color:#7c3aed;

}

.grid{

display:grid;
grid-template-columns:1fr 360px;
gap:2rem;

}

.card{

background:white;
padding:24px;
border-radius:16px;
border:1px solid #e2e8f0;
box-shadow:0 4px 6px rgba(0,0,0,.05);

}

h2{

font-family:'Fredoka';
margin-bottom:8px;

}

.subtitle{

font-size:13px;
color:#64748b;
margin-bottom:24px;

}

.form-group{

margin-bottom:16px;

}

label{

display:block;
margin-bottom:6px;
font-size:11px;
font-weight:600;
text-transform:uppercase;
color:#94a3b8;

}

input{

width:100%;
padding:10px 14px;
border-radius:8px;
border:1px solid #e2e8f0;
font-size:14px;

}

input:focus{

outline:none;
border-color:#7c3aed;

}

.btn-submit{

width:100%;
padding:12px;
border:none;
border-radius:8px;
background:#7c3aed;
color:white;
font-weight:600;
cursor:pointer;

}

.btn-submit:hover{

opacity:.9;

}

.alert{

padding:12px;
border-radius:8px;
margin-bottom:16px;
font-size:13px;

}

.alert-success{

background:#f0fdf4;
color:#16a34a;
border:1px solid #bbf7d0;

}

.alert-error{

background:#fef2f2;
color:#dc2626;
border:1px solid #fecaca;

}

.log-item{

display:flex;
justify-content:space-between;
align-items:center;
padding:12px 0;
border-bottom:1px solid #e2e8f0;

}

.food-title{

font-weight:600;
font-size:13px;

}

.food-time{

font-size:11px;
color:#94a3b8;

}

.food-cals{

font-weight:700;
color:#d97706;

}

.summary-box{

display:flex;
justify-content:space-between;
margin-top:16px;
padding-top:16px;
border-top:2px dashed #e2e8f0;
font-family:'Fredoka';

}

.history-container{

max-height:400px;
overflow-y:auto;

}

</style>

</head>

<body>

<div class="container">

    <div class="header">
        <a href="dashboard.php" class="wordmark">UNI<b>PULSE</b></a>

        <a href="dashboard.php" class="back-btn">
            <i class="ti ti-arrow-left"></i>
            Back to Hub Dashboard
        </a>
    </div>

    <div class="grid">

        <!-- LEFT CARD -->
        <div class="card">

            <h2>Log Food Intake</h2>

            <p class="subtitle">
                Log your meals to keep track of your daily calorie intake.
            </p>

            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success">
                    <?= $success_message ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-error">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="diet.php">

                <div class="form-group">

                    <label>Meal Name</label>

                    <input
                        type="text"
                        name="food_name"
                        placeholder="Example: Chicken Rice"
                        required>

                </div>

                <div class="form-group">

                    <label>Calories (kcal)</label>

                    <input
                        type="number"
                        name="calories"
                        placeholder="Example: 550"
                        min="1"
                        required>

                </div>

                <button
                    type="submit"
                    name="log_food"
                    class="btn-submit">

                    Save to Diary Log 🌸

                </button>

            </form>

        </div>

        <!-- RIGHT CARD -->
        <div class="card">

            <h2>Today's Nutrition History</h2>

            <p class="subtitle">
                <?= date('l, F j, Y'); ?>
            </p>

            <div class="history-container">

                <?php if (empty($dietLogs)) : ?>

                    <div style="text-align:center;padding:30px;color:#94a3b8;font-size:13px;">

                        No meals logged today 🌱

                    </div>

                <?php else : ?>

                    <?php foreach ($dietLogs as $log) : ?>

                        <div class="log-item">

                            <div>

                                <div class="food-title">

                                    <?= htmlspecialchars($log['meal_name']) ?>

                                </div>

                                <div class="food-time">

                                    <?= date('F j, Y', strtotime($log['log_date'])) ?>

                                </div>

                            </div>

                            <div class="food-cals">

                                <?= $log['meal_calories'] ?> kcal

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

            <div class="summary-box">

                <span>📊 Total Intake</span>

                <span style="color:#d97706;font-size:16px;">

                    <?= $totalCaloriesToday ?> kcal

                </span>

            </div>

        </div>

    </div>

</div>

</body>

</html>