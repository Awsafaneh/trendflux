<?php
// هذا الكود مخصص لملف send_email.php

// في بيئة التطوير، يمكنك تفعيل عرض الأخطاء للمساعدة في التصحيح.
// يجب تعطيل هذه الأسطر في بيئة الإنتاج لأسباب أمنية.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    // strip_tags() removes HTML and PHP tags from a string.
    // trim() removes whitespace or other predefined characters from both sides of a string.
    // filter_var() filters a variable with a specified filter (e.g., validate email).
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that data was sent in the POST request.
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set an error message and redirect back to contact page with an error parameter
        header("Location: ../contact.html?status=error_empty_fields");
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
    // Ensure the "From" header is correctly formatted.
    $email_headers = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n"; // Allow direct reply to sender
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-type: text/plain; charset=UTF-8\r\n"; // Ensure correct encoding for Arabic/special characters

    // Send the email.
    // The mail() function might require specific server configurations to work.
    // If you face issues, consider using an SMTP library like PHPMailer.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Success: Redirect back to contact page with a success parameter
        header("Location: ../contact.html?status=success");
        exit;
    } else {
        // Failure: Redirect back to contact page with an error parameter
        header("Location: ../contact.html?status=error_sending_mail");
        exit;
    }

} else {
    // If someone tries to access send_email.php directly via GET request,
    // redirect them to the contact form.
    header("Location: ../contact.html");
    exit;
}
?>
