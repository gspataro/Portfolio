<?php

namespace GSpataro\Pages\Generator;

final class LoopGenerator extends BaseGenerator
{
    /**
     * Generate pages based on schema
     *
     * @param array $schema
     * @return void
     */

    public function generate(array $schema): void
    {
        $other_contents = array_diff($schema['contents'], [$schema['generate_based_on']]);
        $based_on = $this->archive->get($schema['generate_based_on']);

        if (empty($based_on)) {
            return;
        }

        $contents = [];

        if (!empty($other_contents)) {
            foreach ($other_contents as $group) {
                $contents[$group] = $this->archive->get($group);
            }
        }

        $this->pages->set($schema['tag'] . '.builder', $schema['builder']);

        foreach ($based_on as $contentTag => $content) {
            $tag = $schema['tag'] . '.' . $contentTag;

            $this->pages->set($tag, $this->createPage(
                $this->sitemap->add($tag, $schema['slug'] . '/' . $contentTag),
                $schema['template'],
                $schema['builder'],
                array_merge($contents, [$contentTag => $content])
            ));
        }
    }
}
