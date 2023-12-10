<?php

declare(strict_types=1);

namespace app\helpers;

final class Session {

    private const SESSION_STARTED = true;
    private const SESSION_NOT_STARTED = false;
    
    private bool $sessionState = self::SESSION_NOT_STARTED;
    
    private static Session $instance;    

    public static function create() : self {
        if(!isset(self::$instance)) {
            self::$instance = new self;
        }
        self::$instance->startSession();
        return self::$instance;
    }
    
    public function startSession() : bool {
        if($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = @session_start();
        }
        return $this->sessionState;
    }
    
    public function __set(string $name, mixed $value) : void {
        if(isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        $_SESSION[$name] = $value;
    }
    
    public function __get(string $name) : mixed {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }
    
    public function __isset(string $name) : bool {
        return isset($_SESSION[$name]);
    }
    
    public function __unset(string $name) : void {
        unset($_SESSION[$name]);
    }
    
    public function destroy() : bool {
        if($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = @!session_destroy();
            unset($_SESSION);
            return !$this->sessionState;
        }
        return false;
    }
}
?>