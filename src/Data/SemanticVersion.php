<?php

namespace Intrfce\Staircase\Data;

use Intrfce\Staircase\Exceptions\UnableToParseVersionStringException;

class SemanticVersion
{
    public function __construct(
        public readonly int $major,
        public readonly int $minor,
        public readonly int $patch,
    ) {}

    /**
     * @throws UnableToParseVersionStringException
     */
    public static function fromVersionString(string $version): SemanticVersion
    {
        $regex = '/^v?(?<major>\d+)\.(?<minor>\d+)\.(?<patch>\d+)$/';

        if (preg_match($regex, $version, $matches)) {
            return new static(
                (int) $matches['major'],
                (int) $matches['minor'],
                (int) $matches['patch']
            );
        }

        throw new UnableToParseVersionStringException;
    }

    public function toString(): string
    {
        return implode('.', [
            $this->major,
            $this->minor,
            $this->patch,
        ]);
    }

    public function incrementMajor(): SemanticVersion
    {
        return new SemanticVersion($this->major+1, $this->minor, $this->patch);
    }

    public function incrementMinor(): SemanticVersion
    {
        return new SemanticVersion($this->major, $this->minor+1, $this->patch);
    }

    public function incrementPatch(): SemanticVersion {
        return new SemanticVersion($this->major, $this->minor, $this->patch+1);
    }
}
