<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من البيانات المرسلة
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // التحقق من صحة البيانات
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'جميع الحقول مطلوبة']);
        exit;
    }
    
    // التحقق من صحة الإيميل
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'عنوان البريد الإلكتروني غير صحيح']);
        exit;
    }
    
    // إعدادات الإيميل
    $to = "trendfluxjo@gmail.com";
    $email_subject = "رسالة جديدة من موقع TrendFlux Agency: " . $subject;
    
    // تنسيق الرسالة
    $email_body = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
            .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #555; }
            .value { margin-top: 5px; padding: 10px; background: white; border-left: 4px solid #667eea; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>رسالة جديدة من موقع TrendFlux Agency</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>الاسم:</div>
                    <div class='value'>" . htmlspecialchars($name) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>البريد الإلكتروني:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>الموضوع:</div>
                    <div class='value'>" . htmlspecialchars($subject) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>الرسالة:</div>
                    <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // إعداد headers للإيميل
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: noreply@trendfluxagency.com" . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // إرسال الإيميل
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ في إرسال الرسالة. يرجى المحاولة مرة أخرى.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'طريقة الإرسال غير صحيحة']);
}
?>
