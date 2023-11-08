<?php

namespace GSpataro\Project;

use GSpataro\Utilities\DotNavigator;

final class Prototype extends DotNavigator
{
    /**
     * Initialize prototype
     *
     * @param Blueprint $blueprint
     */

    public function __construct(
        private readonly Blueprint $blueprint
    ) {
        $this->prepareContents();
    }

    /**
     * Prepare contents structure
     *
     * @param array $contents
     * @return void
     */

    private function prepareContents(): void
    {
        foreach ($this->blueprint->get('contents') as $type => $definition) {
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

            $this->set('contents.' . $type, new Content(
                $type,
                $definition['template'],
                $definition['output'],
                $definition['data'],
                $definition['archive']
            ));
        }
    }
}
