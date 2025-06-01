<?php
// send_email.php
// هذا الكود سيرجع استجابة JSON بدلاً من إعادة التوجيه

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
    // Collect form data and sanitize it
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that data was sent and is valid
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all required fields and provide a valid email address.';
        echo json_encode($response);
        exit;
    }

    // Set the recipient email address.
    // !! IMPORTANT: Replace "trendfluxjo@gmail.com" with your actual email address !!
    $recipient = "trendfluxjo@gmail.com";

    // Set the email subject line.
    $email_subject = "New Contact Form Message from " . $name . ": " . $subject;

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    // Send the email.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        $response['status'] = 'success';
        $response['message'] = 'Your message has been sent successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'There was an error sending your message. Please try again later.';
        // يمكنك تسجيل خطأ mail() هنا للمراجعة
        // error_log("Failed to send email. From: $email, Subject: $email_subject");
    }

} else {
    // Not a POST request
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
