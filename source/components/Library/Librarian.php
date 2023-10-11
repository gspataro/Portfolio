<?php

namespace GSpataro\Library;

use GSpataro\Application\Project;

final class Librarian
{
    /**
     * Initialize the Librarian object
     *
     * @param Project $project
     * @param ReadersCollection $readers
     */

    public function __construct(
        private readonly Project $project,
        private readonly ReadersCollection $readers
    ) {
    }

    /**
     * Setup project based on blueprint data
     *
     * @return void
     */

    public function run(): void
    {
        foreach ($this->project->getItems() as $id => $item) {
            if (empty($item['data'])) {
                continue;
            }

            $data = [];

            foreach ($item['data'] as $raw_data) {
                $reader = $this->readers->get($raw_data['type']);
                $data = array_merge($data, $reader->compile($raw_data['path']));
            }

            $item['data'] = $data;
            $this->project->setItem($id, $item);
        }
    }
}
