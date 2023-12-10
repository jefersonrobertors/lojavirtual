<?php

declare(strict_types=1);

namespace core\helpers;

use app\interfaces\FlashMessageInterface;
use app\traits\FlashMessageTrait;

class Redirect extends Response implements FlashMessageInterface {
    use FlashMessageTrait;

    public function __construct(string $to) {
        $this->sendStatus(302);
        $this->sendHeader('Location', $to);
    }
}
?>