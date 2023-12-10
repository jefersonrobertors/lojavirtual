<?php

declare(strict_types=1);

namespace core\helpers;

class Request {

    /** @var Sanitize $get */
    public readonly Sanitize $get;

    /** @var Sanitize $post */
    public readonly Sanitize $post;

    /** @var Server $server */
    public readonly Server $server;

    /** @var array $params */
    public readonly array $params;

    public function __construct(Sanitize $get, Sanitize $post) {
        $this->server = Server::create();
        $this->get = $get;
        $this->post = $post;
    }

    public static function create() : self {
        return new static(new Sanitize($_GET), new Sanitize($_POST));
    }

    public function getServer() : Server {
        return $this->server;
    }

    public function setParams(array $params) : self {
        if(!empty($params)) {
            foreach($params as $key => &$value) {
                if(preg_match("/^[0-9]+$/u", $value)) {
                    $value = (int) $value;
                }else if(preg_match("/^(true|false)$/iu", $value)) {
                    $value = (bool) $value;
                }
            }
        }
        $this->params = $params;
        return $this;
    }

    public function getParams() : array {
        return $this->params;
    }

    public function getParameter(string $name) : string {
        $params = $this->getParams();
        return isset($params[$name]) ? $params[$name] : "";
    }

    public function input(string $field) : mixed {
        return $this->getRequest()->get($field);
    }

    public function getRequest(?string $request = null) : Sanitize {
        if($request === null) {
            $request = $this->server->getCurrentHttpMethod();
        }
        $request = strtolower($request);

        if(!in_array($request, ['get', 'post'])) {
            throw new \RuntimeException("The request method $request is not allowed");
        }
        return $this->$request;
    }
}
?>