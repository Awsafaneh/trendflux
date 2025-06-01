<?php
// view_messages.php

session_start(); // بدء الجلسة

// التحقق مما إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: admin_login.php'); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يكن مسجلاً
    exit;
}

// مسار الملف النصي الذي يحفظ الرسائل
// يجب أن يتطابق هذا المسار مع المسار في save_message.php
$log_file = 'messages.log';

$messages_content = '';
if (file_exists($log_file)) {
    $messages_content = file_get_contents($log_file);
} else {
    $messages_content = "No messages found yet.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Saved Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2f2f7d;
            text-align: center;
            margin-bottom: 20px;
        }
        .message-box {
            background-color: #e9e9e9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            white-space: pre-wrap; /* للحفاظ على تنسيق المسافات والأسطر */
            font-family: monospace; /* خط مناسب لعرض النصوص البرمجية */
            color: #333;
            max-height: 500px; /* لتقييد الارتفاع وجعلها قابلة للتمرير */
            overflow-y: auto;
        }
        .logout-button {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            float: right;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_logout.php" class="logout-button">Logout</a>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <h2>Saved Messages</h2>

        <div class="message-box">
            <?php echo htmlspecialchars($messages_content); ?>
        </div>
    </div>
</body>
</html>
