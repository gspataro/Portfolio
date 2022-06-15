<?php

// Include directories aliases

require_once __DIR__ . "/directories.php";

// Include composer autoloader

require_once DIR_VENDOR . "/autoload.php";

// Initialize nunomaduro/collision component

(new \NunoMaduro\Collision\Provider())->register();

// Initialize twig/twig component

$twigLoader = new \Twig\Loader\FilesystemLoader(DIR_VIEW);
$twig = new \Twig\Environment($twigLoader);
