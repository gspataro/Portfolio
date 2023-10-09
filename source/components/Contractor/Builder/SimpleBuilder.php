<?php

namespace GSpataro\Contractor\Builder;

use Twig\Environment as TwigEnvironment;
use GSpataro\Contractor\Interface\BuilderInterface;

final class SimpleBuilder implements BuilderInterface
{
    /**
     * Initialize page builder
     *
     * @param TwigEnvironment $twig
     */

    public function __construct(
        private TwigEnvironment $twig
    ) {
    }

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
