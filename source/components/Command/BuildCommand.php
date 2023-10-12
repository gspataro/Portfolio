<?php

namespace GSpataro\Command;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    public function main(): void
    {
        $this->output->print('Running the building process...');

        $blueprint = $this->app->get('app.blueprint');
        $librarian = $this->app->get('library.librarian');
        $architect = $this->app->get('builder.architect');
        $assets = $this->app->get('assets.handler');
        $locales = $this->app->get('locales');
        $twig = $this->app->get('twig');
        $parsedown = $this->app->get('parsedown');
        $dataBuilder = $this->app->get('builder.data');

        require_once DIR_SOURCE . "/twig_extensions.php";


        $librarian->run();
        $architect->run();
        $assets->run();

        $this->output->print('Build completed!');
    }
}
