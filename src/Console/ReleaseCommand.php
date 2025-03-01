<?php

namespace Intrfce\Staircase\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Intrfce\Staircase\Data\SemanticVersion;
use Intrfce\Staircase\Enums\ReleaseType;
use Intrfce\Staircase\Exceptions\InvalidReleaseStepException;
use Intrfce\Staircase\Exceptions\ReleaseStepFailedException;
use Intrfce\Staircase\Exceptions\UnableToParseVersionStringException;
use Intrfce\Staircase\Helpers\ConfigFileValidator;
use Intrfce\Staircase\Staircase;
use Intrfce\Staircase\Support\ReleaseEngine;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

class ReleaseCommand extends Command
{
    protected $signature = 'staircase:release';

    protected $description = 'Create a new release';

    public function __construct(
        public ConfigFileValidator $configFileValidator,
        public Staircase $staircase
    ) {
        parent::__construct();
    }

    /**
     * @throws InvalidReleaseStepException
     * @throws FileNotFoundException
     * @throws UnableToParseVersionStringException
     */
    public function handle()
    {
        $this->ensureStaircaseFileExists();

        $currentRelease = $this->getCurrentRelease();

        $this->info('Current release: ' . $currentRelease->toString());

        $releaseType = $this->askForReleaseType();

        $nextRelease = $this->getNextReleaseVersion(
            $currentRelease,
            $releaseType
        );

        $this->info('The new release version will be: ' . $nextRelease->toString());

        if(!confirm('Does this look correct?')) {
            return Command::FAILURE;
        }

        try {
            app(ReleaseEngine::class)
                ->doRelease(
                    $releaseType,
                    $currentRelease,
                    $nextRelease,
                    function (string $message) {
                        $this->info($message);
                    }, function (string $message) {
                    $this->error($message);
                });
        } catch (InvalidReleaseStepException|ReleaseStepFailedException $e) {
            $this->error($e->getMessage());
        }
    }

    private function ensureStaircaseFileExists(): void
    {
        if (! File::exists(base_path('staircase.json'))) {
            $this->error("The staircase.json file doesn't exist, have you ran `staircase:init`?");
            exit(Command::FAILURE);
        }

        if (! $this->configFileValidator->isValid(
            File::get(base_path('staircase.json'))
        )) {
            $this->error('The staircase.json file is not valid');
            exit(Command::FAILURE);
        }
    }

    private function askForReleaseType(): ReleaseType
    {
        return ReleaseType::tryFrom(select(
            label: 'What type of release do you want to create?',
            options: collect(ReleaseType::cases())->mapWithKeys(function ($case) {
                return [$case->value => $case->name];
            })
        ));
    }

    private function getNextReleaseVersion(SemanticVersion $currentRelease, ReleaseType $releaseType): SemanticVersion {
        return match ($releaseType) {
            ReleaseType::Major => $currentRelease->incrementMajor(),
            ReleaseType::Minor => $currentRelease->incrementMinor(),
            ReleaseType::Patch => $currentRelease->incrementPatch(),
        };
    }

    /**
     * @throws FileNotFoundException
     * @throws UnableToParseVersionStringException
     */
    private function getCurrentRelease():SemanticVersion
    {
        return SemanticVersion::fromVersionString(data_get(json_decode(File::get(base_path('staircase.json')), true), 'version'));
    }
}
