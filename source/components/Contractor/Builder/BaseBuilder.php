<?php

namespace GSpataro\Contractor\Builder;

use Twig\Environment as TwigEnvironment;
use GSpataro\Contractor\Interface\BuilderInterface;

abstract class BaseBuilder implements BuilderInterface
{
    /**
     * Store instructions
     *
     * @var array
     */

    protected array $instructions = [];

    /**
     * Initialize page builder
     *
     * @param TwigEnvironment $twig
     */

    public function __construct(
        protected readonly TwigEnvironment $twig
    ) {
    }

    /**
     * Setup instructions
     *
     * @param array $instructions
     * @return void
     */

    public function setup(array $instructions): void
    {
        $this->instructions = $instructions;
    }
}
