<?php

namespace GSpataro\Pages\Generator;

final class PaginateGenerator extends BaseGenerator
{
    /**
     * Generate pages based on schema
     *
     * @param array $schema
     * @return void
     */

    public function generate(array $schema): void
    {
        $otherContents = array_diff($schema['contents'], [$schema['generate_based_on']]);
        $basedOn = $this->archive->get($schema['generate_based_on']);

        if (empty($basedOn)) {
            return;
        }

        $contents = [];

        if (!empty($otherContents)) {
            foreach ($otherContents as $group) {
                $contents[$group] = $this->archive->get($group);
            }
        }

        $perPage = 12;
        $totalPages = ceil(count($basedOn) / $perPage);

        $this->createCollection(
            $schema['tag'],
            $schema['template'],
            $schema['builder'],
            $otherContents
        );

        for ($i = 0; $i < $totalPages; $i++) {
            $currentPage = $i + 1;
            $slice = array_slice($basedOn, $i * $perPage, $perPage);

            $this->addPageToCollection(
                $schema['tag'],
                'page-' . $currentPage,
                $this->sitemap->add(
                    $schema['tag'] . '.page-' . $currentPage,
                    $schema['slug'] . ($currentPage > 1 ? '-' . $currentPage : null)
                ),
                [
                    $schema['tag'] => $slice,
                    'pagination' => [
                        'current' => $currentPage,
                        'next' => $currentPage < $totalPages ? $currentPage + 1 : null,
                        'prev' => $currentPage > 1 ? $currentPage - 1 : null
                    ]
                ]
            );
        }
    }
}
