<?php

namespace GSpataro\Project;

readonly final class Content
{
    public function __construct(
        public string $type,
        public string $template,
        public string $output,
        public array $data,
        public bool|array $archive
    ) {
    }
}
