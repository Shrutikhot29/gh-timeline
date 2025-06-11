<?php
session_start();
require_once 'functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        $email = $_POST['unsubscribe_email'];
        $code = generateVerificationCode();
        $_SESSION['unsubscribe_email'] = $email;
        $_SESSION['unsubscribe_code'] = $code;
        sendVerificationEmail($email, $code, true);
        $message = "Unsubscribe code sent to your email.";
    } elseif (isset($_POST['unsubscribe_verification_code'])) {
        if ($_POST['unsubscribe_verification_code'] == $_SESSION['unsubscribe_code']) {
            unsubscribeEmail($_SESSION['unsubscribe_email']);
            $message = "You have been unsubscribed.";
        } else {
            $message = "Incorrect unsubscribe code.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f3f3;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }
        h2 {
            color: #b20000;
        }
        form {
            background: white;
            padding: 20px;
            margin: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 280px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 14px;
        }
        button {
            background-color: #d9534f;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .message {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #ffc107;
            width: 280px;
        }
    </style>
</head>
<body>

<h2>Unsubscribe from Emails</h2>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="POST">
    <label>Your Email:</label>
    <input type="email" name="unsubscribe_email" required>
    <button id="submit-unsubscribe">Unsubscribe</button>
</form>

<form method="POST">
    <label>Verification Code:</label>
    <input type="text" name="unsubscribe_verification_code">
    <button id="verify-unsubscribe">Verify</button>
</form>

</body>
</html>
