<?php

namespace GSpataro\Contractor\Builder;

final class ArchiveBuilder extends BaseBuilder
{
    /**
     * Compile an archive
     *
     * @return void
     */

    public function compile(): void
    {
        if (!isset($this->options['archive_group'])) {
            return;
        }

        $archiveGroup = $this->options['archive_group'];
        $groupContents = $this->contents[$this->options['archive_group']] ?? [];
        $perPage = $this->options['per_page'] ?? 12;
        $totalPages = ceil(count($groupContents ?? []) / $perPage);

        for ($i = 0; $i < $totalPages; $i++) {
            $currentPage = $i + 1;
            $output = $currentPage > 1 ? addSuffixToFilename($this->output, '-' . $currentPage) : $this->output;
            $outputPath = $this->getOutputPath($this->tag . '.page-' . $currentPage, $output);
            $contents = $this->contents;
            $contents[$archiveGroup] = array_slice($groupContents, $i * $perPage, $perPage);
            $contents['pagination'] = [
                'current' => $currentPage,
                'prev' => $currentPage > 1 ? $currentPage - 1 : null,
                'next' => $currentPage < $totalPages ? $currentPage + 1 : null
            ];

            $compiledTemplate = $this->twig->render($this->template . '.html', $contents);
            file_put_contents(pathJoin(DIR_OUTPUT, $outputPath), $compiledTemplate);
        }
    }
}
