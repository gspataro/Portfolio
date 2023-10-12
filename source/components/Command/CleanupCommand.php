<?php

namespace GSpataro\Command;

use DirectoryIterator;

final class CleanupCommand extends BaseCommand
{
    protected string $name = 'cleanup';
    protected ?string $description = 'Remove contents that are no more present in the input directories';

    public function main(): void
    {
        $this->output->print('Running the cleanup process...');

        $project = $this->app->get('app.project');
        $items = array_column($project->getItems(), 'output');
        $outputDirectory = new DirectoryIterator($project->getOutputDir());

        foreach ($outputDirectory as $item) {
            if ($item->isDot()) {
                continue;
            }

            if ($item->getBasename() == 'assets') {
                continue;
            }

            if ($item->isFile() && !in_array($item->getPathname(), $items)) {
                unlink($item->getPathname());
                continue;
            }

            if (!in_array($item->getPathname(), $items) && !in_array($item->getPathname() . '/*', $items)) {
                recursiveDelete($item->getPathname());
                continue;
            }
        }

        $this->output->print('Cleanup completed!');
    }
}
