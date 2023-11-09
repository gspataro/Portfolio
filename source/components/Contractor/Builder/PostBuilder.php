<?php

namespace GSpataro\Contractor\Builder;

final class PostBuilder extends BaseBuilder
{
    /**
     * Compile post
     *
     * @param array $page
     * @return mixed
     */

    public function compile(array $page): void
    {
        foreach ($page as $post) {
            if ($post == 'post') {
                continue;
            }

            $outputPath = $this->getOutputPath($post['permalink']);
            $compiled = $this->twig->render($post['template'] . '.html', $post['contents']);

            file_put_contents($outputPath, $compiled);
        }
    }
}
