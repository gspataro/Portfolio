<?php

namespace GSpataro\Application\Component;

use GSpataro\CLI\Handler;
use GSpataro\CLI\CommandsCollection;
use GSpataro\Command\BuildCommand;
use GSpataro\DependencyInjection\Component;

final class CLIComponent extends Component
{
    public function register(): void
    {
        $this->container->add('cli.commands', fn(): object => new CommandsCollection());

        $this->container->add('cli', function ($container, $args): object {
            return new Handler(
                $container->get('cli.commands')
            );
        });
    }

    public function boot(): void
    {
        $cli = $this->container->get('cli');
        $commands = $this->container->get('cli.commands');

        $commands->register(
            new BuildCommand($this->container)
        );

        $cli->deploy();
    }
}
