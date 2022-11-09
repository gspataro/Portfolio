<?php

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

// Generate pages based on pages.php data

$pages = require_once DIR_SOURCE . "/pages.php";
$langs = ["it", "en"];
$defaultLang = "it";
$globalData = getData("global");

$twig->addFilter(new \Twig\TwigFilter("localize", function ($context, $string) {
    $keys = explode(".", $string);
    $lang = $context['lang']['current'];
    $current = $context;

    foreach ($keys as $key) {
        $current = $current[$key] ?? null;
    }

    if (is_null($current)) {
        return $string;
    }

    return $current[$lang] ?? $current;
}, ['needs_context' => true]));

$twig->addFunction(new \Twig\TwigFunction("link", function ($context, $path) {
    return "{$context['lang']['urlPrefix']}/{$path}";
}, ["needs_context" => true]));

$twig->addFunction(new \Twig\TwigFunction("parsedown", function ($context, $fileName) use ($parsedown) {
    $lang = $context['lang']['current'];

    if (is_file(DIR_DATA . "/markdown/{$fileName}_{$lang}.md")) {
        $raw = file_get_contents(DIR_DATA . "/markdown/{$fileName}_{$lang}.md");
    } else if (is_file(DIR_DATA . "/markdown/{$fileName}.md")) {
        $raw = file_get_contents(DIR_DATA . "/markdown/{$fileName}.md");
    } else {
        return;
    }

    return $parsedown->toHtml($raw);
}, ["needs_context" => true]));

foreach ($langs as $lang) {
    $globalData['lang'] = [
        'current' => $lang,
        'urlPrefix' => $lang != $defaultLang ? "/{$lang}" : ""
    ];

    foreach ($pages as $outputPath => $page) {
        $data = $globalData;
        $outputPathPrefix = $lang != $defaultLang ? "/{$lang}" : "";

        if (isset($page['data']) && !empty($page['data'])) {
            if (is_array($page['data'])) {
                foreach ($page['data'] as $dataFileName) {
                    $data += getData($dataFileName);
                }
            } else {
                $data += getData($page['data']);
            }
        }

        compilePage($outputPathPrefix . $outputPath, $page['template'], $data, $twig);
    }
}

$assets = require_once DIR_SOURCE . "/assets.php";
copyAssets($assets);
