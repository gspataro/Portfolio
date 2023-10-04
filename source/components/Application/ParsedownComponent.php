<?php

namespace GSpataro\Application;

use Erusev\Parsedown\Parsedown;
use GSpataro\DependencyInjection\Component;

final class ParsedownComponent extends Component
{
    public function register(): void
    {
        $this->container->add('parsedown', fn(): object => new Parsedown());
    }

    public function boot(): void
    {
    }
}
