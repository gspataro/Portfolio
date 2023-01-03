<?php

namespace GSpataro\Builder;

use GSpataro\Builder\Exception\DataFileNotFoundException;

final class Data
{
    /**
     * Store loaded data
     *
     * @var array
     */

    private array $data = [];

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
            throw new Exception\DataFileNotFoundException(
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

    /**
     * Get data
     *
     * @param string $query
     * @return mixed
     */

    public function get(string $query): mixed
    {
        $keys = explode(".", $query);
        $result = $this->data;

        foreach ($keys as $key) {
            if (!isset($result[$key])) {
                $result = $query;
                break;
            }

            $result = $result[$key];
        }

        return $result;
    }
}
