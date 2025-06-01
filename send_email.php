<?php
// تحتاج لتحميل PHPMailer أولاً: composer require phpmailer/phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
    
    $mail = new PHPMailer(true);
    
    try {
        // إعدادات SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'trendfluxjo@gmail.com';  // الإيميل الخاص بك
        $mail->Password   = 'your_app_password_here';  // كلمة مرور التطبيق (ليس كلمة المرور العادية)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // إعداد المرسل والمستقبل
        $mail->setFrom('trendfluxjo@gmail.com', 'TrendFlux Agency');
        $mail->addAddress('trendfluxjo@gmail.com');
        $mail->addReplyTo($email, $name);
        
        // محتوى الرسالة
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'رسالة جديدة من موقع TrendFlux Agency: ' . $subject;
        
        $mail->Body = "
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
        
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.']);
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ في إرسال الرسالة: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'طريقة الإرسال غير صحيحة']);
}
?>
