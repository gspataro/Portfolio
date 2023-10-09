<?php

namespace GSpataro\Contractor\Builder;

final class SimpleBuilder extends BaseBuilder
{
    /**
     * Compile a page
     *
     * @param string $templateName
     * @param string $outputPath
     * @param array $data
     * @return void
     */

    public function compile(string $templateName, string $outputPath, array $data = []): void
    {
        $outputDirName = pathinfo($outputPath, PATHINFO_DIRNAME);

        if (!is_dir($outputDirName)) {
            mkdir($outputDirName, true);
        }

        $compiledTemplate = $this->twig->render("{$templateName}.html", $data);
        file_put_contents($outputPath, $compiledTemplate);
    }
}
