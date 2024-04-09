<?php

namespace GSpataro\View;

use Twig\TwigFunction;
use Tempest\Highlight\Highlighter;
use Twig\Extension\AbstractExtension;

final class TwigHighlighter extends AbstractExtension
{
    public function __construct(
        private readonly Highlighter $highlighter,
    ) {
    }

    public function highlight($code, $language)
    {
        return $this->highlighter->parse($code, $language);
    }

    public function getFunctions()
    {
        $functions = [];

        $functions[] = new TwigFunction('highlight', [$this, 'highlight']);

        return $functions;
    }
}
