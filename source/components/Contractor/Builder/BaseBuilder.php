<?php

namespace GSpataro\Contractor\Builder;

use GSpataro\Project\Sitemap;
use Twig\Environment as TwigEnvironment;
use GSpataro\Contractor\Interface\BuilderInterface;

abstract class BaseBuilder implements BuilderInterface
{
    /**
     * Initialize page builder
     *
     * @param Sitemap $sitemap
     * @param TwigEnvironment $twig
     */

    public function __construct(
        protected readonly Sitemap $sitemap,
        protected readonly TwigEnvironment $twig
    ) {
    }

    /**
     * Get output path
     * The output path will be transformed into a unique one and registered in the sitemap
     * If the output base directory doesn't exists, it will be created recursively
     *
     * @param string $path
     * @param string|null $groupName
     * @return string
     */

    protected function getOutputPath(string $path, ?string $groupName = null): string
    {
        $outputPath = DIR_OUTPUT . DIRECTORY_SEPARATOR . $path;
        $outputDirName = pathinfo($outputPath, PATHINFO_DIRNAME);
        $outputFileName = pathinfo($outputPath, PATHINFO_FILENAME);

        if (!is_dir($outputDirName)) {
            mkdir($outputDirName, 0777, true);
        }

        $tag = ($groupName ? $groupName . '.' : null) . $outputFileName;

        return $this->sitemap->add($tag, $outputPath);
    }
}
