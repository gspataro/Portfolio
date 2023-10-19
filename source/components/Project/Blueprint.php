<?php

namespace GSpataro\Project;

use GSpataro\Library\Exception\InvalidDataItemException;
use GSpataro\Project\Exception\InvalidItemException;
use GSpataro\Utilities\DotNavigator;

final class Blueprint extends DotNavigator
{
    protected bool $readOnly = true;

    /**
     * Initialize blueprint
     *
     * @param string $filePath
     */

    public function __construct(string $filePath)
    {
        if (!is_file($filePath)) {
            throw new Exception\InvalidBlueprintException(
                "Blueprint file not found: '{$filePath}'."
            );
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension !== 'json') {
            throw new Exception\InvalidBlueprintException(
                "Invalid blueprint provided. The blueprint file must be a json file."
            );
        }

        $rawJson = file_get_contents($filePath);
        $data = $this->readData($rawJson);

        $this->fill($data);
    }

    /**
     * Read user given data
     *
     * @param string $rawJson
     * @return array
     */

    private function readData(string $rawJson): array
    {
        $data = json_decode($rawJson, true);

        if (isset($data['items'])) {
            $this->prepareItems($data['items']);
        }

        return $data;
    }

    /**
     * Prepare items structure
     *
     * @param array $items
     * @return void
     */

    private function prepareItems(array &$items): void
    {
        foreach ($items as $i => &$item) {
            if (!isset($item['template'])) {
                throw new Exception\InvalidItemException(
                    "Item number '{$i}' must contain a template index."
                );
            }

            if (!isset($item['output'])) {
                throw new Exception\InvalidItemException(
                    "Item number '{$i}' must contain an output index."
                );
            }

            $item['builder'] ??= 'simple';

            if (!isset($item['contents'])) {
                $item['contents'] = [];
                continue;
            }

            if (!is_array($item['contents'])) {
                throw new Exception\InvalidItemException(
                    "Contents of item number '{$i}' must be an associative array."
                );
            }

            $this->prepareItemContents($item['contents']);
        }
    }

    /**
     * Prepare item contents
     *
     * @param array $contents
     * @return void
     */

    private function prepareItemContents(array &$contents): void
    {
        foreach ($contents as $tag => &$source) {
            if (!is_string($source)) {
                throw new InvalidItemException(
                    "Invalid source provided for content with tag '{$tag}'. It must be a string."
                );
            }

            if (str_contains($source, ':')) {
                [$reader, $path] = explode(':', $source, 2);
            }

            $source = [
                'reader' => $reader ?? 'text',
                'source' => $path ?? $source
            ];
        }
    }
}
