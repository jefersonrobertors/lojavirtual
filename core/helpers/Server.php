<?php

declare(strict_types=1);

namespace core\helpers;

final class Server {

    private readonly array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public static function create() : self {
        return new self($_SERVER);
    }

    public function getPathApplication() : string {
        return base_path() . DIRECTORY_SEPARATOR . "app";
    }

    public function getPublicPath() : string {
        return base_path() . DIRECTORY_SEPARATOR . "public";
    }

    public function getCurrentHttpMethod() : string {
        return $this->data['REQUEST_METHOD'];
    }

    public function getQueryString() : string {
        return $this->data['QUERY_STRING'] ?? "";
    }

    public function getCurrentPath() : string {
        $uri = $this->data['REQUEST_URI'];

        if(false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        if($uri !== ROUTER_SEPARATOR) {
            $uri = rtrim($uri, ROUTER_SEPARATOR);
        }
        return rawurldecode($uri);
    }
}
?>