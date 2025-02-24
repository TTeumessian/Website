<?php
session_start();

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // CSRF Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = 'Invalid form submission';
    }

    // Spam Prevention - Check if honeypot field is empty
    if (!empty($_POST['website'])) { // Honeypot field should be empty
        die();
    }

    // Rate Limiting
    if (isset($_SESSION['last_submission_time'])) {
        $time_elapsed = time() - $_SESSION['last_submission_time'];
        if ($time_elapsed < 300) { // 5 minutes cooldown
            $errors[] = 'Please wait before submitting another request';
        }
    }

    // Input Validation
    $organization = trim(htmlspecialchars($_POST['organization'] ?? ''));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $message = trim(htmlspecialchars($_POST['message'] ?? ''));
    
    // Validation checks
    if (empty($organization) || strlen($organization) > 100) {
        $errors[] = 'Invalid organization name';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($message) || strlen($message) > 3000) {
        $errors[] = 'Invalid message content';
    }

    if (empty($errors)) {
        $to = "mitche11o41904@gmail.com"; // Replace with your email address
        $subject = "New Consultation Request from " . htmlspecialchars($organization);
        
        $email_content = "Organization: " . htmlspecialchars($organization) . "\n";
        $email_content .= "Email: " . htmlspecialchars($email) . "\n\n";
        $email_content .= "Message:\n" . htmlspecialchars($message);
        
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $email_content, $headers)) {
            $_SESSION['last_submission_time'] = time();
            header("Location: consulting.html?status=success");
            exit();
        } else {
            $errors[] = 'Failed to send email';
        }
    }

    if (!empty($errors)) {
        $error_string = implode(',', array_map('urlencode', $errors));
        header("Location: consulting.html?status=error&message=" . $error_string);
        exit();
    }
} else {
    header("Location: consulting.html");
    exit();
}
?>