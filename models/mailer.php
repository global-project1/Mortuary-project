<?php

    require $_SESSION['root_dir'] . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable($_SESSION['root_dir'] . '/');
    $dotenv->load();

    use PHPMailer\PHPMailer\PHPMailer;

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username   = $_ENV['username'];                 
    $mail->Password   = $_ENV['password'];                        
    $mail->SMTPSecure =PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 25;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->isHTML(true);
    $mail->setFrom('HG@example.com', "Heaven's gate");

    return $mail;

?>