<?php

/**
 * Recursively copy a file or directory to another location excluding the items in the $exclude array
 *
 * @param string $from
 * @param string $top
 * @param array $exclude
 * @return void
 */

function recursiveCopy(string $from, string $to, array $exclude = []): void
{
    if (!is_dir($to)) {
        mkdir($to, 0777, true);
    }

    $directory = new DirectoryIterator($from);

    foreach ($directory as $item) {
        if ($item->isDot()) {
            continue;
        }

        $source = $item->getPathname();
        $destination = $to . '/' . $item->getBasename();

        if (in_array($item->getBasename(), $exclude)) {
            continue;
        }

        if (is_file($source)) {
            copy($source, $destination);
            continue;
        }

        recursiveCopy($source, $destination, $exclude);
    }
}

/**
 * Get string between
 *
 * @param string $string
 * @param string $openTag
 * @param string $closeTag
 * @return string|null
 */

function getStringBetween(string $string, string $openTag, string $closeTag): ?string
{
    $start = strpos($string, $openTag);

    if ($start == 0) {
        return null;
    }

    $start += strlen($openTag);
    $end = strpos($string, $closeTag, $start) - $start;

    return substr($string, $start, $end);
}
