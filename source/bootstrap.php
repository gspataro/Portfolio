<?php

use GSpataro\Localization;
use GSpataro\Builder;
use Erusev\Parsedown\Parsedown;

// Include directories aliases

require_once __DIR__ . "/directories.php";

// Include composer autoloader

require_once DIR_VENDOR . "/autoload.php";

// Initialize nunomaduro/collision component

(new \NunoMaduro\Collision\Provider())->register();

// Initialize parsedown

$parsedown = new Parsedown();

// Initialize twig/twig component

$twigLoader = new \Twig\Loader\FilesystemLoader(DIR_VIEW);
$twig = new \Twig\Environment($twigLoader);
$twig->addExtension(new \Twig\Extra\String\StringExtension());

// Load data from blueprint.json

$rawBlueprint = file_get_contents(DIR_ROOT . "/blueprint.json");
$blueprint = json_decode($rawBlueprint, true);

// Initialize localization

$locales = new Localization\Locales();

foreach ($blueprint['languages'] as $langKey) {
    $locales->addLanguage(new Localization\Language($langKey, DIR_LANGS . "/{$langKey}"));
}

// Initialize builder

$dataBuilder = new Builder\Data(DIR_DATA);
$pageBuilder = new Builder\Page($twig);

foreach ($blueprint['data'] as $dataFile) {
    $dataBuilder->load($dataFile);
}

// Include twig extensions

require_once DIR_SOURCE . "/twig_extensions.php";

// Include build process

require_once DIR_SOURCE . "/build_process.php";
