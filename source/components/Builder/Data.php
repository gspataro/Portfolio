<?php

namespace GSpataro\Builder;

use GSpataro\Utilities\DotNavigator;
use GSpataro\Builder\Exception\DataFileNotFoundException;

final class Data extends DotNavigator
{
    /**
     * Store loaded data
     *
     * @var array
     */

    protected bool $readOnly = true;

    /**
     * Initialize data builder
     *
     * @param string $dataPath
     */

    public function __construct(
        private string $dataPath
    ) {
    }

    /**
     * Get data file
     *
     * @param string $fileName
     * @return string
     */

    private function getFile(string $fileName): string
    {
        $filePath = "{$this->dataPath}/{$fileName}.json";

        if (!is_file($filePath)) {
            throw new DataFileNotFoundException(
                "Data file not found: {$filePath}"
            );
        }

        return file_get_contents($filePath);
    }

    /**
     * Load data
     *
     * @param string $fileName
     * @return void
     */

    public function load(string $fileName): void
    {
        if (isset($this->data[$fileName])) {
            return;
        }

        $rawData = $this->getFile($fileName);
        $this->data[$fileName] = json_decode($rawData, true);
    }
}
