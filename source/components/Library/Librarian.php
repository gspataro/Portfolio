<?php

namespace GSpataro\Library;

use GSpataro\Application\Project;

final class Librarian
{
    /**
     * Store compiled data
     *
     * @var array
     */

    private array $data = [];

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
                $path = $raw_data['path'];

                if (!isset($this->data[$path])) {
                    $reader = $this->readers->get($raw_data['type']);
                    $this->data[$path] = $reader->compile($path);
                }

                $data = array_merge($data, $this->data[$path]);
            }

            $item['data'] = $data;
            $this->project->setItem($id, $item);
        }
    }
}
