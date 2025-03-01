<?php

namespace Intrfce\Staircase\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class InitCommand extends Command
{
    protected $signature = 'staircase:init';

    protected $description = 'Command description';

    public function handle()
    {
        if (File::exists(base_path('staircase.json'))) {
            $this->warn('A staircase.json file already exists.');

            return Command::SUCCESS;
        }

        info('Welcome to Staircase, let\'s get started...');

        info("First, let's set the initial release version.");
        info('If you already have a semantic release version number, type it below');
        info('in the format {major}.{minor}.{patch}, otherwise, we recommend starting with 1.0.0');

        $current = text(
            label: 'Initial/Current Semantic Release Version',
            placeholder: '{major}.{minor}.{patch}',
            default: '1.0.0',
            validate: function (string $value) {
                if (str_starts_with($value, 'v')) {
                    return 'Looks like you prefixed the version with a V, you can leave that off';
                }
                $versionParts = explode('.', $value);
                if (count($versionParts) !== 3) {
                    return 'This doesnt look like a valid semantic version number';
                }
                foreach ($versionParts as $versionPart) {
                    if (! is_numeric($versionPart)) {
                        return 'This doesnt look like a valid semantic version number';
                    }
                }
            }
        );

        File::put(
            base_path('staircase.json'),
            json_encode([
                'version' => $current,
                JSON_PRETTY_PRINT,
            ])
        );

        info("Awesome, we've written that version number to your new staircase.json file");
    }
}
