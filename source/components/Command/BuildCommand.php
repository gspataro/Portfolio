<?php

namespace GSpataro\Command;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    public function main(): void
    {
        $this->output->print('Running the building process...');

        $librarian = $this->app->get('library.librarian');
        $architect = $this->app->get('builder.architect');
        $assets = $this->app->get('assets.handler');

        $librarian->run();
        $architect->run();
        $assets->run();

        $this->output->print('Build completed!');
    }
}
