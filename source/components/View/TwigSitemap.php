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

        if (!str_ends_with($url, '/') && !str_starts_with($path, '/')) {
            $separator = '/';
        }

        if (!str_ends_with($path, '.html')) {
            $path .= '.html';
        }

        if (str_ends_with($path, 'index.html')) {
            $path = substr($path, 0, strlen('index.html') * -1);
        }

        return $url . $separator . $path;
    }

    public function getFunctions()
    {
        $functions = [];

        $functions[] = new TwigFunction('url', [$this, 'url']);

        return $functions;
    }
}
