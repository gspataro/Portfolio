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
