<?php

namespace GSpataro\View;

use Twig\TwigFunction;
use GSpataro\Project\Sitemap;
use GSpataro\Project\Blueprint;
use Twig\Extension\AbstractExtension;

final class TwigSitemap extends AbstractExtension
{
    public function __construct(
        private readonly Blueprint $blueprint,
        private readonly Sitemap $sitemap
    ) {
    }

    public function url($tag)
    {
        return $this->blueprint->get('website.url') . '/' . $this->sitemap->get($tag);
    }

    public function getFunctions()
    {
        $functions = [];

        $functions[] = new TwigFunction('url', [$this, 'url']);

        return $functions;
    }
}
