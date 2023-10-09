<?php

namespace GSpataro\Contractor\Builder;

use Twig\Environment as TwigEnvironment;
use GSpataro\Contractor\Interface\BuilderInterface;

abstract class BaseBuilder implements BuilderInterface
{
    /**
     * Initialize page builder
     *
     * @param TwigEnvironment $twig
     */

    public function __construct(
        protected readonly TwigEnvironment $twig
    ) {
    }
}
