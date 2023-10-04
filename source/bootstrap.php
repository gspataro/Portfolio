<?php

use GSpataro\Builder;
use GSpataro\Application;
use GSpataro\DependencyInjection\Container;

// Include directories aliases

require_once __DIR__ . "/directories.php";

// Include composer autoloader

require_once DIR_VENDOR . "/autoload.php";

// Initialize nunomaduro/collision component

(new \NunoMaduro\Collision\Provider())->register();

// Initialize dependency injection container

$app = new Container();
$app->loadComponents([
    Application\CLIComponent::class,
    Application\TwigComponent::class,
    Application\ParsedownComponent::class,
    Application\LocalizationComponent::class,
    Application\BlueprintComponent::class,
    Application\BuilderComponent::class
]);
$app->boot();
