<?php

use GSpataro\Application\Component;
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
    Component\LocalizationComponent::class,
    Component\TwigComponent::class,
    Component\ApplicationComponent::class,
    Component\MarkdownComponent::class,
    Component\LibraryComponent::class,
    Component\ContractorComponent::class,
    Component\AssetsComponent::class,
    Component\CLIComponent::class
]);
$app->boot();
