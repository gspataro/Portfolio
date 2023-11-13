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
        $otherContents = array_diff($schema['contents'], [$schema['generate_based_on']]);
        $basedOn = $this->archive->get($schema['generate_based_on']);

        if (empty($basedOn)) {
            return;
        }

        $contents = [];

        if (!empty($otherContents)) {
            foreach ($otherContents as $group) {
                $contents[$group] = $this->archive->get($group);
            }
        }

        //$this->pages->set($schema['tag'] . '.builder', $schema['builder']);
        $this->createCollection(
            $schema['tag'],
            $schema['template'],
            $schema['builder'],
            $otherContents
        );

        foreach ($basedOn as $contentTag => $content) {
            $tag = $schema['tag'] . '.' . $contentTag;

            /*$this->createPage(
                $tag,
                $this->sitemap->add($tag, $schema['slug'] . '/' . $contentTag),
                $schema['template'],
                $schema['builder'],
                array_merge($contents, [$schema['tag'] => $content])
            );*/
            $this->addPageToCollection(
                $schema['tag'],
                $contentTag,
                $this->sitemap->add($tag, $schema['slug'] . '/' . $contentTag),
                [$schema['tag'] => $content]
            );
        }
    }
}
