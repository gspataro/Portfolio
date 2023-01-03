<?php

// Start building process

foreach ($locales->getAll() as $lang) {
    $twig->addGlobal('lang', [
        'current' => $lang->key,
        'urlPrefix' => $lang->key != $blueprint['default_language'] ? "/{$lang->key}" : ""
    ]);

    foreach ($blueprint['pages'] as $page) {
        $outputPathPrefix = $lang->key != $blueprint['default_language'] ? "/{$lang->key}" : "";
        $pageBuilder->compile($page['template'], $outputPathPrefix . $page['output']);
    }
}

//$assets = require_once DIR_SOURCE . "/assets.php";
//copyAssets($assets);
