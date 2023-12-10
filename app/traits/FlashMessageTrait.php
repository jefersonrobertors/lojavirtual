<?php

declare(strict_types=1);

namespace app\traits;

trait FlashMessageTrait {

    public function danger(string $name, string $message) : void {
        $this->set($name, FLASH_DANGER, $message);
    }

    public function warning(string $name, string $message) : void {
        $this->set($name, FLASH_WARNING, $message);
    }

    public function info(string $name, string $message) : void {
        $this->set($name, FLASH_INFO, $message);
    }

    public function success(string $name, string $message) : void {
        $this->set($name, FLASH_SUCCESS, $message);
    }

    private function set(string $name, string $type, string $message) : void {
        $session = session();

        $flashData = isset($session->flash) ? $session->flash : array();

        if(isset($flashData[$name])) unset($flashData[$name]);

        $icon = match($type) {
            FLASH_DANGER, FLASH_WARNING => '<i class="bi bi-exclamation-circle-fill me-2" style="color: currentColor;"></i>',
            FLASH_INFO => '<i class="bi bi-info-circle-fill me-2" style="color: currentColor;"></i>',
            FLASH_SUCCESS => '<i class="bi bi-check-circle-fill me-2" style="color: currentColor;"></i>',
            default => ''
        };
        $flashMessage = '<div class="alert alert-%s d-flex align-items-center" role="alert" style="height: 42px">%s';
        $flashMessage .= '<button type="button" class="btn-close shadow-none position-absolute" style="right:10px" data-bs-dismiss="alert" aria-label="Close"></button>';
        $flashMessage .= '</div>';
        
        $message = sprintf($flashMessage, $type, $icon . $message);

        $flashData[$name] = $message;
        
        $session->flash = $flashData;
    }
}
?>