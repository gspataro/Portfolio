<?php

namespace GSpataro\Command;

use GSpataro\CLI\Command;
use GSpataro\DependencyInjection\Container;

class BaseCommand extends Command
{
    public function __construct(
        protected Container $app
    ) {
    }
}