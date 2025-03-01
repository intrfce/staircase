<?php

namespace Intrfce\Staircase\Contracts;

use Intrfce\Staircase\Data\ReleaseStepResult;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseType;

interface ReleaseStep
{
    public function name(): string;

    public function build(ReleaseType $releaseType, SemanticVersion $currentVersion, SemanticVersion $nextVersion): ReleaseStepResult;
}
