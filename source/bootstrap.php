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

// Generate pages based on pages.php data

$pages = require_once DIR_SOURCE . "/pages.php";
$globalData = getData("global");

foreach ($pages as $outputPath => $page) {
    $data = $globalData;

    if (isset($page['data']) && !empty($page['data'])) {
        if (is_array($page['data'])) {
            foreach ($page['data'] as $dataFileName) {
                $data += getData($dataFileName);
            }
        } else {
            $data += getData($page['data']);
        }
    }

    compilePage($outputPath, $page['template'], $data, $twig);
}
