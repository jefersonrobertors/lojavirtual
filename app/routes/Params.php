<?php

declare(strict_types=1);

namespace app\routes;

use core\helpers\Server;

final class Params {

    private readonly Server $server;
    private readonly string $known_uri;
    private readonly string $given_uri;

    public function __construct(string $known) {
        $this->server = Server::create();
        $this->given_uri = $this->server->getCurrentPath();
        $this->known_uri = $known;
    }

    public function getDiffPathGiven() : array {
        return array_diff(explode(ROUTER_SEPARATOR, $this->given_uri), explode(ROUTER_SEPARATOR, $this->known_uri));
    }

    public function getDiffPathKnown() : array {
        return array_diff(explode(ROUTER_SEPARATOR, $this->known_uri), explode(ROUTER_SEPARATOR, $this->given_uri));
    }

    public function getQueryParams() : array {
        $string = $this->server->getQueryString();
        $params = [];

        if(!empty($string)) {
            foreach(explode('&', $string) as $param) {
                $key = substr($param, 0, strpos($param, '='));
                $value = substr($param, strpos($param, '=') + 1);
                $params[$key] = $value;
            }
        }
        return $params;
    }

    public function getPathParams() : array {
        $params = [];
        $known = $this->getDiffPathKnown();
        $given = $this->getDiffPathGiven();

        if(!empty($known)) {
            foreach($known as $key => $value) {
                if(isset($given[$key])) {
                    $params[explode(':', $value)[0]] = $given[$key];
                }
            }
        }
        return $params;
    }

    public function getParams() : array {
        return array_merge($this->getPathParams(), $this->getQueryParams());
    }
}
?>