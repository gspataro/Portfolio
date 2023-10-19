<?php

namespace GSpataro\Application\Component;

use GSpataro\Library\Archive;
use GSpataro\Library\ReadersCollection;
use GSpataro\Library\Reader\TextReader;
use GSpataro\DependencyInjection\Component;
use GSpataro\Library\Reader\MarkdownReader;

final class LibraryComponent extends Component
{
    public function register(): void
    {
        $this->container->add('library.readers', function ($container, $args): object {
            return new ReadersCollection();
        });

        $this->container->add('library.archive', function ($container, $args): object {
            return new Archive();
        });
    }

    public function boot(): void
    {
        $readersCollection = $this->container->get('library.readers');

        $readersCollection->add('text', new TextReader());
        $readersCollection->add('markdown', new MarkdownReader(
            $this->container->get('markdown.converter')
        ));
    }
}
