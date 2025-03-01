<?php

namespace Intrfce\Staircase\BuildSteps;

use Intrfce\Staircase\Contracts\ReleaseStep;
use Intrfce\Staircase\Data\ReleaseStepResult;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseType;

/**
 * Create a git release branch using the given prefix in config.
 */
class CreateGitReleaseBranch implements ReleaseStep
{
    public function name(): string
    {
        return 'Creating Git Release Branch';
    }

    public function build(ReleaseType $releaseType, SemanticVersion $currentVersion, SemanticVersion $nextVersion): ReleaseStepResult
    {
        // TODO: Implement build() method.
    }
}
