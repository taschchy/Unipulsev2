<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = mysqli_connect("mysql", "unipulse", "secret", "unipulse");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("
    SELECT mood, log_date
    FROM user_moods
    WHERE user_id = ?
    ORDER BY log_date DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mood History</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            padding:30px;
        }

        h2{
            text-align:center;
        }

        table{
            width:80%;
            margin:auto;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #ddd;
            padding:12px;
            text-align:center;
        }

        th{
            background:#6C63FF;
            color:white;
        }

        tr:nth-child(even){
            background:#f4f4f4;
        }
    </style>
</head>

<body>

<h2>My Mood History</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Mood</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>

    <tr>
        <td>
            <?php echo date('d M Y', strtotime($row['log_date'])); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['mood']); ?>
        </td>
    </tr>

    <?php } ?>
</table>

</body>
</html>