<?php

namespace GSpataro\Contractor\Builder;

final class ProjectsBuilder extends BaseBuilder
{
    /**
     * Compile projects
     *
     * @param array $item
     * @return void
     */

    public function compile(array $item): void
    {
        foreach ($item['contents']['projects'] as $content) {
            $outputPath = $this->getOutputPath(
                $item['output'] . DIRECTORY_SEPARATOR . $content['meta']['slug'] . '.html',
                $item['group'] ?? null
            );

            $compiledTemplate = $this->twig->render("{$item['template']}.html", [
                'project' => $content
            ]);
            file_put_contents($outputPath, $compiledTemplate);
        }
    }
}
