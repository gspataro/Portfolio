<?php

namespace GSpataro\Project;

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

        $this->prepareContents($data['contents']);

        return $data;
    }

    /**
     * Prepare contents structure
     *
     * @param array $contents
     * @return void
     */

    private function prepareContents(array &$contents): void
    {
        foreach ($contents as $type => &$definition) {
            $definition['type'] = $type;
            $definition['template'] ??= 'post';
            $definition['output'] ??= DIRECTORY_SEPARATOR . $type;
            $definition['data'] ??= [
                [
                    'reader' => 'markdown',
                    'path' => $type . DIRECTORY_SEPARATOR . '*.md'
                ]
            ];
            $definition['archive'] ??= false;

            if ($definition['archive']) {
                $definition['archive']['template'] ??= 'archive';
                $definition['archive']['slug'] ??= $type;
                $definition['archive']['per_page'] ??= 12;
            }

            if (!is_array($definition['data'])) {
                $definition['data'] = [$definition['data']];
            }

            foreach ($definition['data'] as &$source) {
                if (str_contains($source, ':')) {
                    [$reader, $path] = explode(':', $source, 2);
                }

                $source = [
                    'reader' => $reader ?? 'text',
                    'path' => $path ?? $source
                ];
            }

            $definition = new Content(
                $type,
                $definition['template'],
                $definition['output'],
                $definition['data'],
                $definition['archive']
            );
        }
    }
}
