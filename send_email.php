<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Set the recipient email address.
    // Replace this with your actual email address
    $recipient = "trendfluxjo@gmail.com";

    // Set the email subject line.
    $email_subject = "New Contact Form Message from " . $name . ": " . $subject;

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Set a success message and redirect back to contact page with a success parameter
        header("Location: ../contact.html?status=success");
        exit;
    } else {
        // Set an error message and redirect back to contact page with an error parameter
        header("Location: ../contact.html?status=error");
        exit;
    }

} else {
    // Not a POST request, redirect to the contact form.
    header("Location: ../contact.html");
    exit;
}
?>
