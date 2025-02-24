<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "your-email@domain.com"; // Replace with your email address
    $organization = $_POST['organization'];
    $from = $_POST['email'];
    $message = $_POST['message'];
    
    $subject = "New Consultation Request from $organization";
    
    $email_content = "Organization: $organization\n";
    $email_content .= "Email: $from\n\n";
    $email_content .= "Message:\n$message";
    
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    if(mail($to, $subject, $email_content, $headers)) {
        header("Location: consulting.html?status=success");
    } else {
        header("Location: consulting.html?status=error");
    }
} else {
    header("Location: consulting.html");
}
?>