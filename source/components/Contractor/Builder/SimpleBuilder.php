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
        $outputPath = $this->getOutputPath($this->tag, $this->output);

        $compiledTemplate = $this->twig->render($this->template . '.html', $this->contents);
        file_put_contents(pathJoin(DIR_OUTPUT, $outputPath), $compiledTemplate);
    }
}
