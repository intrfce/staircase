<?php

namespace Intrfce\Staircase\BuildSteps;

use Intrfce\Staircase\Contracts\ReleaseStep;
use Intrfce\Staircase\Contracts\ReleaseStepContract;
use Intrfce\Staircase\Data\ReleaseStepResult;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseType;

class BuildAssets implements ReleaseStep
{
    public function name(): string
    {
        return 'Building assets';
    }

    public function build(ReleaseType $releaseType, SemanticVersion $currentVersion, SemanticVersion $nextVersion): ReleaseStepResult
    {
        // TODO: Implement build() method.
    }
}
