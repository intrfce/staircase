<?php

namespace Intrfce\Staircase\Support;

use Closure;
use Illuminate\Support\Collection;
use Intrfce\Staircase\BuildSteps\BuildAssets;
use Intrfce\Staircase\BuildSteps\CreateGitReleaseBranch;
use Intrfce\Staircase\BuildSteps\CreateGitTag;
use Intrfce\Staircase\BuildSteps\EnsureCleanGitDirectory;
use Intrfce\Staircase\BuildSteps\PushToGitRemote;
use Intrfce\Staircase\BuildSteps\UpdateConfigFile;
use Intrfce\Staircase\Contracts\ReleaseStep;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseStepStatus;
use Intrfce\Staircase\Enums\ReleaseType;
use Intrfce\Staircase\Exceptions\InvalidReleaseStepException;
use Intrfce\Staircase\Exceptions\ReleaseStepFailedException;

class ReleaseEngine
{
    public function doRelease(ReleaseType $releaseType, SemanticVersion $currentRelease, SemanticVersion $nextRelease, Closure $infoMessage, Closure $errorMessage): void
    {
        $this
            ->getReleaseSteps()
            ->map(fn (string $classString) => app($classString))
            ->each(function($step) {
                if (!($step instanceof ReleaseStep)) {
                    throw new InvalidReleaseStepException();
                }
            })
            ->each(function (ReleaseStep $step) use ($releaseType, $currentRelease, $nextRelease, $infoMessage, $errorMessage) {

            $infoMessage($step->name().'...');

            $result = $step->build($releaseType, $currentRelease, $nextRelease);
//
            if ($result->status === ReleaseStepStatus::Failed) {
                throw new ReleaseStepFailedException($result->errorMessage);
            }
        });
    }

    protected function getReleaseSteps(): Collection
    {
        $anyGitIntegration = config('staircase.build_assets') || config('staircase.create_release_branch') || config('staircase.create_git_tags');

        return collect([])
            ->when(
                $anyGitIntegration,
                fn (Collection $steps) => $steps->push(EnsureCleanGitDirectory::class)
            )
            ->when(
                config('staircase.create_git_tags'),
                fn (Collection $steps) => $steps->push(CreateGitTag::class)
            )
            ->when(
                config('staircase.create_release_branch'),
                fn (Collection $steps) => $steps->push(CreateGitReleaseBranch::class)
            )
            ->when(
                config('staircase.build_assets'),
                fn (Collection $steps) => $steps->push(BuildAssets::class)
            )
            ->push(
                UpdateConfigFile::class
            )
            ->when(
                $anyGitIntegration,
                fn (Collection $steps) => $steps->push(PushToGitRemote::class)
            );
    }
}
