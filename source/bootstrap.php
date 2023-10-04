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
    Application\TwigComponent::class,
    Application\ParsedownComponent::class,
    Application\LocalizationComponent::class,
    Application\BlueprintComponent::class,
    Application\BuilderComponent::class
]);
$app->boot();

// Build process

$blueprint = $app->get('blueprint');
$locales = $app->get('locales');
$twig = $app->get('twig');
$parsedown = $app->get('parsedown');
$dataBuilder = $app->get('builder.data');
$pageBuilder = $app->get('builder.page');

require_once DIR_SOURCE . "/twig_extensions.php";

foreach ($locales->getAll() as $lang) {
    $twig->addGlobal('lang', [
        'current' => $lang->key,
        'urlPrefix' => $lang->key != $blueprint->get('default_language') ? "/{$lang->key}" : ""
    ]);

    foreach ($blueprint->get('pages') as $page) {
        $outputPathPrefix = $lang->key != $blueprint->get('default_language') ? "/{$lang->key}" : "";
        $pageBuilder->compile($page['template'], $outputPathPrefix . $page['output']);
    }
}
