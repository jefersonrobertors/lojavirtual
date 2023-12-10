<?php

use core\services\mail\Mail;

if(!function_exists('sendmail')) {
    function sendmail(string $to, string $subject, string $body) {
        $mail = new Mail;
        $mail->addAddress($to);

        $mail->setMessage($body);
        $mail->setSubject($subject);

        return $mail->send();
    }
}
?>