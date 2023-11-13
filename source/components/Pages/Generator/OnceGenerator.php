<?php

namespace GSpataro\Pages\Generator;

final class OnceGenerator extends BaseGenerator
{
    /**
     * Generate pages based on schema
     *
     * @param array $schema
     * @return void
     */

    public function generate(array $schema): void
    {
        $contents = [];

        if (!empty($schema['contents'])) {
            foreach ($schema['contents'] as $group) {
                $contents[$group] = $this->archive->get($group);
            }
        }

        $this->createPage(
            $schema['tag'],
            $this->sitemap->add($schema['tag'], $schema['slug']),
            $schema['template'],
            $schema['builder'],
            $contents
        );
    }
}
