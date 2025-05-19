<?php

namespace GSpataro\View;

use Twig\TwigFilter;
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

    public function pregMatch($subject, $pattern)
    {
        $matches = [];
        preg_match($pattern, $subject, $matches);

        return $matches;
    }

    public function pregReplace($subject, $pattern, $replacement)
    {
        return preg_replace($pattern, $replacement, $subject);
    }

    public function getFilters()
    {
        $filters = [];

        $filters[] = new TwigFilter('highlight', [$this, 'highlight'], [
            'is_safe' => ['html']
        ]);
        $filters[] = new TwigFilter('preg_match', [$this, 'pregMatch']);
        $filters[] = new TwigFilter('preg_replace', [$this, 'pregReplace']);

        return $filters;
    }
}
