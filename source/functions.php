<?php

/**
 * Load JSON data from the data directory and return it as array
 *
 * @param string $fileName
 * @return array
 */

function getData(string $fileName): array
{
    $filePath = DIR_DATA . "/{$fileName}.json";

    if (!file_exists($filePath)) {
        throw new Exception("Data file not found: '{$fileName}'.");
    }

    $rawData = file_get_contents($filePath);
    return json_decode($rawData, true);
}

/**
 * Compile a page and put it on the public folder
 *
 * @param string $outputPath
 * @param string $template
 * @param array $data
 * @param \Twig\Environment $twig
 * @return void
 */

function compilePage(string $outputPath, string $template, array $data, \Twig\Environment $twig): void
{
    $compiledTemplate = $twig->render("{$template}.html", $data);
    file_put_contents(DIR_PUBLIC . "{$outputPath}", $compiledTemplate);
}
