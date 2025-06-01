<?php
// هذا هو الكود الكامل لملف send_email.php

// في بيئة التطوير، يمكنك تفعيل عرض الأخطاء للمساعدة في التصحيح.
// يجب تعطيل هذه الأسطر في بيئة الإنتاج لأسباب أمنية.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// تعيين رأس (Header) الاستجابة إلى JSON
header('Content-Type: application/json');

// تهيئة مصفوفة الاستجابة الافتراضية للخطأ
$response = [
    'status' => 'error',
    'message' => 'An unknown error occurred. Please try again.'
];

// التحقق مما إذا كان الطلب من نوع POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع بيانات النموذج وتصفيتها لزيادة الأمان
    // strip_tags(): لإزالة أي علامات HTML أو PHP من المدخلات لمنع هجمات XSS.
    // trim(): لإزالة المسافات البيضاء من بداية ونهاية السلسلة.
    // filter_var() مع FILTER_SANITIZE_EMAIL: لتنظيف عنوان البريد الإلكتروني من أي أحرف غير صالحة.
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // التحقق من أن جميع الحقول المطلوبة مملوءة وأن البريد الإلكتروني صالح
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all required fields and provide a valid email address.';
        echo json_encode($response); // إرسال الاستجابة JSON والإنهاء
        exit;
    }

    // تعيين عنوان البريد الإلكتروني للمستلم
    // !! هام جداً: استبدل "trendfluxjo@gmail.com" ببريدك الإلكتروني الفعلي !!
    $recipient = "trendfluxjo@gmail.com"; // البريد الإلكتروني الذي ستصلك عليه الرسائل

    // تعيين موضوع الرسالة الإلكترونية
    $email_subject = "New Contact Form Message from " . $name . ": " . $subject;

    // بناء محتوى الرسالة الإلكترونية (نص عادي)
    $email_content = "Name: " . $name . "\n";
    $email_content .= "Email: " . $email . "\n\n";
    $email_content .= "Subject: " . $subject . "\n\n";
    $email_content .= "Message:\n" . $message . "\n";

    // بناء رؤوس البريد الإلكتروني (Headers)
    // "From": يحدد من أرسل الرسالة.
    // "Reply-To": يحدد العنوان الذي يجب الرد عليه.
    // "MIME-Version" و "Content-type": لدعم الأحرف غير اللاتينية (مثل العربية) والتأكد من أنها نص عادي.
    $email_headers = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    // محاولة إرسال البريد الإلكتروني باستخدام دالة mail()
    // دالة mail() تتطلب إعدادات خادم بريد (MTA) عاملة على الخادم.
    // إذا واجهت مشاكل، قد تحتاج إلى استخدام مكتبة SMTP مثل PHPMailer (موصى بها للموثوقية).
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // إذا تم الإرسال بنجاح
        $response['status'] = 'success';
        $response['message'] = 'Your message has been sent successfully!';
    } else {
        // إذا فشل الإرسال (على الرغم من أن دالة mail() قد ترجع true حتى لو لم يتم الإرسال فعلياً)
        $response['status'] = 'error';
        $response['message'] = 'There was an error sending your message. Please try again later.';
        // يمكنك تسجيل الخطأ هنا للمراجعة إذا كان لديك نظام تسجيل أخطاء:
        // error_log("Failed to send email. From: $email, Subject: $email_subject, Error Info: " . error_get_last()['message']);
    }

} else {
    // إذا حاول شخص ما الوصول إلى هذا الملف مباشرةً عبر طلب GET (وليس POST)
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method. Access denied.';
}

// إرجاع الاستجابة بصيغة JSON إلى JavaScript
echo json_encode($response);
?>
