<?php
// Your secret key from reCAPTCHA
$recaptcha_secret = '6LfCVJgqAAAAAJbVtTciyfdKtg-LJcfS3Duv9wji'; // Replace with your actual secret key

// Get the reCAPTCHA response token from the form submission
$recaptcha_response = $_POST['g-recaptcha-response'];

// Verify the response with Google
$verify_url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response,
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($verify_url, false, $context);
$resultJson = json_decode($result);

// Check if reCAPTCHA was successful
if ($resultJson->success) {
    // Redirect to Calendly instead of Qualtrics
    header("Location: https://calendly.com/lindseycosartyoung/capstone-interviews");
    exit();
} else {
    // Show error message
    echo "CAPTCHA verification failed. Please try again.";
}
?>
