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

/**
 * Copy assets to the public dir
 *
 * @param array $assets
 * @return void
 */

function copyAssets(array $assets): void
{
    foreach ($assets as $asset => $output) {
        $asset = DIR_VIEW . "/assets/{$asset}";
        $output = DIR_PUBLIC . "/assets/{$output}";

        if (!is_file($asset)) {
            throw new Exception("Asset not found: '{$asset}'.");
        }

        copy($asset, $output);
    }
}

/**
 * Recursively copy a directory
 *
 * @param string $inputDirectory
 * @param string $outputDirectory
 * @param array $exclude
 * @return void
 */

function recursiveCopy(string $inputDirectory, string $outputDirectory, $exclude = []): void
{
    if (!is_dir($inputDirectory)) {
        throw new Exception(
            "Input directory not found: {$inputDirectory}"
        );
    }

    $structure = scandir($inputDirectory);

    if (!is_dir($outputDirectory)) {
        mkdir($outputDirectory);
    }

    foreach ($structure as $item) {
        if ($item == "." || $item == "..") {
            continue;
        }

        $inputItemPath = "{$inputDirectory}/{$item}";
        $outputItemPath = "{$outputDirectory}/{$item}";

        if (in_array($inputItemPath, $exclude)) {
            continue;
        }

        if (is_dir($inputItemPath)) {
            recursiveCopy($inputItemPath, $outputItemPath, $exclude);
        }

        if (is_file($inputItemPath)) {
            copy($inputItemPath, $outputItemPath);
        }
    }
}
