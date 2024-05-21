<?php
    if(!isset($_SESSION['corpse_remover'])){
        if(!isset($_SESSION['userInfo'])){
            header("Location: /index");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP  Confirmation</title>

    <link rel="stylesheet" href="assets/css/otp.css">
    <!-- link to font icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <div class="form">
        <form method="post">
            <h1>Enter verification code</h1>
            <?php
                if(isset($_SESSION['otp_error'])){
                    echo "<p class='error_msg'> {$_SESSION['otp_error']}</p>";
                    unset($_SESSION['otp_error']);
                }
            ?>
            <p>Enter 6 Digit OTP code that has been sent to your email</p>
            <label>Enter code here:</label>
            <input type="code" placeholder="Six-Digit code" name="otp" required>
            <input type="submit" value="submit" name="otpSubmit" class="submit">
        </form>
    </div>
</body>
</html>