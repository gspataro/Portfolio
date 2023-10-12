<?php

namespace GSpataro\Application\Component;

use GSpataro\Library\Librarian;
use GSpataro\Library\ReadersCollection;
use GSpataro\Library\Reader\TextReader;
use GSpataro\DependencyInjection\Component;
use GSpataro\Library\Reader\MarkdownReader;

final class LibraryComponent extends Component
{
    public function register(): void
    {
        $this->container->add('library.collection', function ($container, $args): object {
            return new ReadersCollection();
        });

        $this->container->add('library.librarian', function ($container, $args): object {
            return new Librarian(
                $container->get('app.project'),
                $container->get('library.collection')
            );
        });
    }

    public function boot(): void
    {
        $readersCollection = $this->container->get('library.collection');

        $readersCollection->add('text', new TextReader());
        $readersCollection->add('markdown', new MarkdownReader(
            $this->container->get('markdown.converter')
        ));
    }
}
