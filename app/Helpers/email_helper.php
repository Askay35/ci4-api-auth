<?php


function sendVerificationCode($email, $code)
{

    $mail = \Config\Services::email();

    log_message('debug',$mail->SMTPPass);
    $mail->setTo($email);
    $mail->setFrom($mail->fromEmail, $mail->fromName);

    $mail->setSubject('[' . $mail->fromName .  '] Код подтверждения электронной почты');
    $mail->setMessage("<h1><p>Код подтверждения: <b>$code</b></p></h1>");
    return $mail->send();
}
