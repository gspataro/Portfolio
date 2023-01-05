<?php

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
