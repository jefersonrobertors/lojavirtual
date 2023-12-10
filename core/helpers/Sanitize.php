<?php

declare(strict_types=1);

namespace core\helpers;

final class Sanitize {

    private array $data = [];

    public function __construct(array $request) {
        foreach($request as $key => $value) {
            $sanitizedValue = trim($value);
            $sanitizedValue = stripslashes($sanitizedValue);
            $sanitizedValue = htmlspecialchars($sanitizedValue);
            $sanitizedValue = strip_tags($sanitizedValue);
            $this->data[$key] = $sanitizedValue;
        }
    }

    public function get(string $key) : mixed {
        return $this->data[$key] ?? null;
    }

    public function all() : array {
        return $this->data;
    }
}
?>