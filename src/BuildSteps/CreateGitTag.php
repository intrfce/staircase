<?php

namespace Intrfce\Staircase\BuildSteps;

use Intrfce\Staircase\Contracts\ReleaseStep;
use Intrfce\Staircase\Data\ReleaseStepResult;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseStepStatus;
use Intrfce\Staircase\Enums\ReleaseType;

/**
 * Create a tag for the new release version.
 */
class CreateGitTag implements ReleaseStep
{

    public function name(): string
    {
        return 'Creating tag in git';
    }

    public function build(ReleaseType $releaseType, SemanticVersion $currentVersion, SemanticVersion $nextVersion): ReleaseStepResult
    {
        return new ReleaseStepResult(
            ReleaseStepStatus::Failed,
            "error message from ".__CLASS__
        );
    }
}
