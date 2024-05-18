<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailerPHPMailerException;

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your@example.com';
    $mail->Password = 'your_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('your@example.com', "Heaven's gate");

?>