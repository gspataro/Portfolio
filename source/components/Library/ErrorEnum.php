<?php

namespace GSpataro\Library;

enum ErrorEnum
{
    case SpacesInFilename;

    public function getMessage(): string
    {
        return match ($this) {
            ErrorEnum::SpacesInFilename => 'Contents sources filenames should not contain spaces.'
        };
    }
}
