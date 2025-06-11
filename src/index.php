<?php
session_start();
require_once 'functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $code = generateVerificationCode();
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $code;
        sendVerificationEmail($email, $code);
        $message = "Verification code sent to your email.";
    } elseif (isset($_POST['verification_code'])) {
        if ($_POST['verification_code'] == $_SESSION['verification_code']) {
            registerEmail($_SESSION['email']);
            $message = "Email verified and registered successfully.";
        } else {
            $message = "Incorrect verification code.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
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
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            margin: 15px;
            border-radius: 7px;
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
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .message {
            background: #e7f3fe;
            color: #31708f;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #2196F3;
            width: 280px;
        }
    </style>
</head>
<body>

<h2>Email Subscription</h2>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>
    <button id="submit-email">Submit</button>
</form>

<form method="POST">
    <label>Verification Code:</label>
    <input type="text" name="verification_code" maxlength="6" required>
    <button id="submit-verification">Verify</button>
</form>

</body>
</html>
