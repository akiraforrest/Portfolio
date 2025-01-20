<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $title = htmlspecialchars(trim($_POST['title']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Define recipient and email subject
    $to = "your-email@example.com"; // Replace with your email
    $subject = "Contact Form Submission: " . $title;

    // Create email body
    $body = "氏名: " . $name . "\n";
    $body .= "Eメール: " . $email . "\n";
    $body .= "タイトル: " . $title . "\n";
    $body .= "メッセージ:\n" . $message;

    // Set email headers
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect or show a success message
        echo "<script>alert('メッセージが送信されました！'); window.location.href='thank_you.html';</script>";
    } else {
        // Show an error message if the email fails to send
        echo "<script>alert('メッセージの送信に失敗しました。もう一度お試しください。');</script>";
    }
}
?>
