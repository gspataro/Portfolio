<?php

namespace GSpataro\Pages\Generator;

use GSpataro\Pages\Pages;
use GSpataro\Library\Archive;
use GSpataro\Project\Sitemap;
use GSpataro\Pages\Interface\GeneratorInterface;

abstract class BaseGenerator implements GeneratorInterface
{
    /**
     * Initialize generator
     *
     * @param Pages $pages
     * @param Archive $archive
     * @param Sitemap $sitemap
     */

    public function __construct(
        protected readonly Pages $pages,
        protected readonly Archive $archive,
        protected readonly Sitemap $sitemap
    ) {
    }

    /**
     * Create page
     *
     * @param string $tag
     * @param string $permalink
     * @param string $template
     * @param string $builder
     * @param array $contents
     * @return void
     */

    protected function createPage(
        string $tag,
        string $permalink,
        string $template,
        string $builder,
        array $contents = []
    ): void {
        $this->pages->set($tag, [
            'permalink' => $permalink,
            'template' => $template,
            'builder' => $builder,
            'contents' => $contents
        ]);
    }
}
