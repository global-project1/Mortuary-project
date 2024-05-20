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
            <p>Enter 6 Digit OTP code that has been sent to your email</p>
            <label>Enter code here:</label>
            <input type="code" placeholder="Six-Digit code" name="otp">
            <input type="submit" value="submit" name="otpSubmit" class="submit">
        </form>
    </div>
</body>
</html>