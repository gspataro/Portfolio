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
        $url = $this->blueprint->get('website.url');
        $path = $this->sitemap->get($tag);
        $separator = null;
        $suffix = null;

        if (!str_ends_with($url, '/') && !str_starts_with($path, '/')) {
            $separator = '/';
        }

        if (!str_ends_with($path, '.html')) {
            $suffix = '.html';
        }

        if ($path == '/index') {
            $path = null;
            $separator = null;
            $suffix = null;
        }

        return $url . $separator . $path . $suffix;
    }

    public function getFunctions()
    {
        $functions = [];

        $functions[] = new TwigFunction('url', [$this, 'url']);

        return $functions;
    }
}
