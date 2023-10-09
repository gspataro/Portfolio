<?php

namespace GSpataro\Contractor\Builder;

final class SimpleBuilder extends BaseBuilder
{
    /**
     * Compile a page
     *
     * @return void
     */

    public function compile(): void
    {
        foreach ($this->instructions as $item) {
            $outputDirName = pathinfo($item['output'], PATHINFO_DIRNAME);

            if (!is_dir($outputDirName)) {
                mkdir($outputDirName, true);
            }

            $compiledTemplate = $this->twig->render("{$item['template']}.html");
            file_put_contents($item['output'], $compiledTemplate);
        }
    }
}
