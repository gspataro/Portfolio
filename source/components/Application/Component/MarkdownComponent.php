<?php

namespace GSpataro\Application\Component;

use League\CommonMark\MarkdownConverter;
use GSpataro\DependencyInjection\Component;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

final class MarkdownComponent extends Component
{
    public function register(): void
    {
        $this->container->add('markdown.environment', function ($container, $args): object {
            return new Environment($args['options'] ?? []);
        });

        $this->container->add('markdown.converter', function ($container, $args): object {
            return new MarkdownConverter(
                $container->get('markdown.environment')
            );
        });
    }

    public function boot(): void
    {
        $environment = $this->container->get('markdown.environment', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());
    }
}
