<?php
// save_message.php
// هذا الملف سيقوم بحفظ بيانات النموذج في ملف نصي

// في بيئة التطوير، يمكنك تفعيل عرض الأخطاء للمساعدة في التصحيح.
// يجب تعطيل هذه الأسطر في بيئة الإنتاج لأسباب أمنية.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json'); // إخبار المتصفح بأن الاستجابة هي JSON

$response = [
    'status' => 'error',
    'message' => 'An unknown error occurred. Please try again.'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع بيانات النموذج وتصفيتها
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // التحقق من أن جميع الحقول المطلوبة مملوءة وأن البريد الإلكتروني صالح
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please fill in all required fields and provide a valid email address.';
        echo json_encode($response);
        exit;
    }

    // بناء محتوى الرسالة التي سيتم حفظها في الملف النصي
    $log_entry = "========================================\n";
    $log_entry .= "Date: " . date('Y-m-d H:i:s') . "\n";
    $log_entry .= "Name: " . $name . "\n";
    $log_entry .= "Email: " . $email . "\n";
    $log_entry .= "Subject: " . ($subject ?: "N/A") . "\n"; // إذا لم يكن هناك موضوع، يكتب N/A
    $log_entry .= "Message:\n" . $message . "\n";
    $log_entry .= "========================================\n\n";

    // مسار الملف النصي لحفظ الرسائل
    // !! هام جداً: غيّر 'messages.log' إلى مسار خارج مجلد الويب العام قدر الإمكان لزيادة الأمان !!
    // مثلاً: '../private_data/messages.log' إذا كان private_data فوق public_html
    // أو التأكد من حمايته بـ .htaccess (انظر أدناه)
    $log_file = 'messages.log';

    // حفظ الرسالة في الملف النصي
    // FILE_APPEND: لإضافة المحتوى إلى نهاية الملف بدلاً من الكتابة فوقه.
    // LOCK_EX: لمنع الكتابة المتزامنة التي قد تسبب تلف البيانات.
    if (file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX) !== false) {
        $response['status'] = 'success';
        $response['message'] = 'Your message has been sent successfully!';
    } else {
        $response['message'] = 'Could not save message. Please try again later.';
        // يمكنك تسجيل هذا الخطأ في ملف لـ debugging
        // error_log("Error saving message to log file: " . error_get_last()['message']);
    }

} else {
    $response['message'] = 'Invalid request method. Access denied.';
}

echo json_encode($response);
?>
