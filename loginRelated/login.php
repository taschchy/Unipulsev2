<?php
// Show error message if login failed
$error = isset($_GET['error']) ? "Invalid username or password!" : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniPulse Login</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* container */
.login-box {
    width: 380px;
    padding: 40px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
    text-align: center;
}

/* title */
.login-box h2 {
    margin-bottom: 10px;
}

/* input */
.login-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    outline: none;
}

/* button */
.login-box button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    border-radius: 8px;
    background: #00c6ff;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.login-box button:hover {
    background: #0072ff;
}

/* error */
.error {
    color: #ffdddd;
    background: rgba(255,0,0,0.3);
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>

</head>

<body>

<div class="login-box">

    <h2>🌙 UniPulse</h2>
    <p>Student Wellness Companion</p>

    <?php if ($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form action="login_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p style="margin-top:15px;">
        Don't have an account?
        <br>
        <a href="register_user.php" style="color: #D3D3D3;">Register New User</a>
    </p>

</div>

</body>
</html>