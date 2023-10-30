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
     * The output path will be transformed into a unique one and registered in the sitemap with the appropriate tag
     * If the output base directory doesn't exists, it will be created recursively
     *
     * @param string $tag
     * @param string $path
     * @return string
     */

    protected function getOutputPath(string $tag, string $path): string
    {
        $outputDirName = pathinfo($path, PATHINFO_DIRNAME);
        $outputDirPath = pathJoin(DIR_OUTPUT, $outputDirName);

        if (!is_dir($outputDirPath)) {
            mkdir($outputDirPath, 0777, true);
        }

        return $this->sitemap->add($tag, $path);
    }
}
