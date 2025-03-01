<?php

namespace Intrfce\Staircase\BuildSteps;

use Intrfce\Staircase\Contracts\ReleaseStep;
use Intrfce\Staircase\Data\ReleaseStepResult;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseType;

/**
 * Push the newly tagged branch, or the new release branch, to the git remote.
 */
class PushToGitRemote implements ReleaseStep
{
    public function name(): string
    {
        return 'Pushing to git remote';
    }

    public function build(ReleaseType $releaseType, SemanticVersion $currentVersion, SemanticVersion $nextVersion): ReleaseStepResult
    {
        // TODO: Implement build() method.
    }
}
