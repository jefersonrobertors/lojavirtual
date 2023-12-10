<?php

declare(strict_types=1);

namespace core\helpers;

use League\Plates\Engine;

class Response {

    private string|array $body = '';

    private array $headers = [];

    private int $response_code = 0;

    public function __construct() { }

    public static function create() : self {
        return new self;
    }

    public function write(string|array $body) : self {
        $this->body = $body;
        return $this;
    }

    public function sendStatus(int $status) : self {
        $this->response_code = $status;
        return $this;
    }

    public function redirect(string $to) : Redirect {
        if(substr($to, 0, 1) !== ROUTER_SEPARATOR) {
            $to = ROUTER_SEPARATOR . $to;
        }
        return new Redirect($to);
    }

    public function sendHeader(string $key, string $value) : self {
        $this->headers[$key] = $value;
        return $this;
    }

    public function sendHeaders(array $headers) : self {
        $this->headers = $headers;
        return $this;
    }

    public function sendFile(string $name, array $data = []) : self {
        $parts = @pathinfo($name, PATHINFO_ALL);

        $templates = new Engine(Server::create()->getPathApplication() . "/views", $parts['extension'] ?? 'php');
        $template = $templates->render($parts['filename'], $data);

        return $this->write($template);
    }

    public function send() : void {
        http_response_code($this->response_code);
        
        if(!empty($this->headers)) {
            foreach($this->headers as $key => $value) {
                header("$key: $value");
            }
        }
        if(!empty($this->body)) {
            echo (in_array('application/json', $this->headers) ? json_encode($this->body) : $this->body);
        }
    }
}
?>