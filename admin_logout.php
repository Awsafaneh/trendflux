<?php
// admin_logout.php

session_start(); // بدء الجلسة

// إلغاء جميع متغيرات الجلسة
$_SESSION = array();

// تدمير الجلسة
session_destroy();

// إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
header('Location: admin_login.php');
exit;
?>
