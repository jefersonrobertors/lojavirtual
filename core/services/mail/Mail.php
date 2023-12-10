<?php

declare(strict_types=1);

namespace core\services\mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class Mail {

    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();

        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;

        $this->mail->Host = env('MAIL_HOST');
        $this->mail->Username = env('MAIL_USERNAME');
        $this->mail->Password = env('MAIL_PASSWORD');
        $this->mail->Port = env('MAIL_PORT');

        $this->mail->setFrom(env('MAIL_SENDER'));

        $this->mail->isHTML(true);

        $this->mail->CharSet = 'UTF-8';
    }

    public function setMessage(string $message) {
        $this->mail->Body = $message;
    }

    public function addAddress($address) {
        $this->mail->addAddress($address);
    }

    public function setSubject(string $subject) {
        $this->mail->Subject = $subject;
    }

    public function send() : bool {
        try {
            return $this->mail->send();
        }catch(Exception $e) {
            echo $e->getMessage();
            echo $this->mail->ErrorInfo;
        }
        return false;
    }
}
?>