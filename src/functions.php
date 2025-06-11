<?php
function generateVerificationCode() {
    return rand(100000, 999999);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $emails = array_filter($emails, fn($e) => trim($e) !== $email);
    file_put_contents($file, implode(PHP_EOL, $emails) . PHP_EOL);
}

function sendVerificationEmail($email, $code, $unsubscribe = false) {
    $subject = $unsubscribe ? 'Confirm Unsubscription' : 'Your Verification Code';
    $message = $unsubscribe ?
        "<p>To confirm unsubscription, use this code: <strong>$code</strong></p>" :
        "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "MIME-Version: 1.0\r\n" .
               "Content-type:text/html;charset=UTF-8\r\n" .
               "From: no-reply@example.com\r\n";
    mail($email, $subject, $message, $headers);
}

function fetchGitHubTimeline() {
    return file_get_contents('https://www.github.com/timeline'); // Dummy
}

function formatGitHubData($data) {
    return "<h2>GitHub Timeline Updates</h2>
    <table border='1'>
    <tr><th>Event</th><th>User</th></tr>
    <tr><td>Push</td><td>testuser</td></tr>
    </table>
    <p><a href='unsubscribe.php' id='unsubscribe-button'>Unsubscribe</a></p>";
}

function sendGitHubUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $data = fetchGitHubTimeline();
    $html = formatGitHubData($data);
    $subject = 'Latest GitHub Updates';
    $headers = "MIME-Version: 1.0\r\n" .
               "Content-type:text/html;charset=UTF-8\r\n" .
               "From: no-reply@example.com\r\n";
    foreach ($emails as $email) {
        mail($email, $subject, $html, $headers);
    }
}