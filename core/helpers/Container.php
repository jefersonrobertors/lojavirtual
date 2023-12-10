<?php

declare(strict_types=1);

namespace core\helpers;

use DI\Container as DIContainer;
use DI\ContainerBuilder;

final class Container {

    public static function create() : self {
        return new self;
    }

    public function build(array $definitions) : DIContainer {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($definitions);

        $containerClass = $containerBuilder->build();

        return $containerClass;
    }
}
?>