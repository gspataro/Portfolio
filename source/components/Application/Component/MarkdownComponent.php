<?php

namespace GSpataro\Application\Component;

use GSpataro\DependencyInjection\Component;
use League\CommonMark\CommonMarkConverter;

final class MarkdownComponent extends Component
{
    public function register(): void
    {
        $this->container->add('markdown.commonmark', function ($container, $args): object {
            return new CommonMarkConverter($args['options'] ?? []);
        });
    }

    public function boot(): void
    {
        $commonMark = $this->container->get('markdown.commonmark', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false
        ]);
    }
}
