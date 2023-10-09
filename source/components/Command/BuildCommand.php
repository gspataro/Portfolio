<?php

namespace GSpataro\Command;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    public function main(): void
    {
        $this->output->print('Running the building process...');

        $blueprint = $this->app->get('blueprint');
        $architect = $this->app->get('builder.architect');
        $locales = $this->app->get('locales');
        $twig = $this->app->get('twig');
        $parsedown = $this->app->get('parsedown');
        $dataBuilder = $this->app->get('builder.data');

        require_once DIR_SOURCE . "/twig_extensions.php";

        foreach ($locales->getAll() as $lang) {
            $twig->addGlobal('lang', [
                'current' => $lang->key,
                'urlPrefix' => $lang->key != $blueprint->get('default_language') ? "/{$lang->key}" : ""
            ]);
            $outputPathPrefix = $lang->key != $blueprint->get('default_language') ? "/{$lang->key}" : "";

            $architect->setupProject(DIR_OUTPUT . $outputPathPrefix);
            $architect->executeBuild();
        }

        $this->output->print('Build completed!');
    }
}
