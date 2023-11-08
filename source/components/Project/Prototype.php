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
        $this->readContents();
        $this->readPages();
    }

    /**
     * Read contents from blueprint
     *
     * @return void
     */

    public function readContents(): void
    {
        $this->set('contents', []);

        if (empty($this->blueprint->get('contents'))) {
            return;
        }

        foreach ($this->blueprint->get('contents') as $group => $source) {
            if (!str_contains($source, ':')) {
                throw new Exception\InvalidBlueprintException(
                    "Invalid data source for group '{$group}'. A data source must be in the format of 'reader:path'."
                );
            }

            [$reader, $path] = explode(':', $source, 2);

            $this->set('contents.' . $group, [
                'reader' => $reader,
                'path' => $path
            ]);
        }
    }

    /**
     * Read pages from blueprint
     *
     * @return void
     */

    public function readPages(): void
    {
        $this->set('pages', []);

        if (empty($this->blueprint->get('pages'))) {
            return;
        }

        foreach ($this->blueprint->get('pages') as $tag => $page) {
            if (!isset($page['template'])) {
                throw new Exception\InvalidBlueprintException(
                    "You must provide a template for page '{$tag}'."
                );
            }

            if (!isset($page['builder'])) {
                throw new Exception\InvalidBlueprintException(
                    "You must provide a builder for page '{$tag}'."
                );
            }

            if (!isset($page['slug'])) {
                throw new Exception\InvalidBlueprintException(
                    "You must provide a slug for page '{$tag}'."
                );
            }

            if (!str_starts_with($page['slug'], '/')) {
                $page['slug'] = '/' . $page['slug'];
            }

            $page['contents'] ??= [];
            $page['options'] ??= [];

            $this->set('pages.' . $tag, $page);
        }
    }
}
