<?php

namespace GSpataro\Builder;

use GSpataro\Builder\Exception\InvalidBlueprintException;
use GSpataro\Utilities\DotNavigator;

final class Blueprint extends DotNavigator
{
    protected bool $readOnly = true;

    /**
     * Initialize blueprint
     *
     * @param string $filePath
     */

    public function __construct(string $filePath)
    {
        if (!is_file($filePath)) {
            throw new InvalidBlueprintException(
                "Blueprint file not found: '{$filePath}'."
            );
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension !== 'json') {
            throw new InvalidBlueprintException(
                "Invalid blueprint provided. The blueprint file must be a json file."
            );
        }

        $rawJson = file_get_contents($filePath);
        $data = json_decode($rawJson, true);

        $this->fill($data);
    }
}
