<?php

declare(strict_types=1);

namespace app\helpers;

use app\interfaces\FlashMessageInterface;

use app\traits\FlashMessageTrait;

class Flash implements FlashMessageInterface {
    use FlashMessageTrait;

    public static function get(string $name) : string {
        $session = session();

        $flashData = isset($session->flash) ? $session->flash : array();

        $message = "";

        if(isset($flashData[$name])) {
            $message = $flashData[$name];
            unset($flashData[$name]);
        }
        $session->flash = $flashData;

        return $message;
    }
}
?>