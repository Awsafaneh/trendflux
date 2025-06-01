<?php
// admin_login.php

session_start(); // بدء جلسة PHP

// بيانات المستخدم (يمكنك تغييرها)
// !! هام جداً: في بيئة الإنتاج، استخدم تجزئة (hashing) لكلمات المرور (مثل password_hash).
$valid_username = 'admin';
$valid_password = 'aboyaser123'; // غيّر هذا!

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // التحقق من بيانات تسجيل الدخول
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: view_messages.php'); // إعادة التوجيه إلى صفحة عرض الرسائل
        exit;
    } else {
        $login_error = 'Invalid username or password.';
    }
}

// إذا كان المستخدم مسجلاً بالفعل، أعد توجيهه
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: view_messages.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .login-container button {
            background-color: #2f2f7d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-container button:hover {
            background-color: #e74c3c;
        }
        .error-message {
            color: #f44336;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($login_error): ?>
            <p class="error-message"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
