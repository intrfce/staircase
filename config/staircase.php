<?php

return [

    /**
     * Should staircase run your asset build step for you.
     * options: true, false, 'production_only'
     */
    'build_assets' => false,

    /**
     * If 'build_assets' is true, what command should staircase run.
     */
    'asset_build_command' => 'npm run build',

    /**
     * Should we create a git tag when creating a release.
     * options: true, false, 'production_only'
     */
    'create_git_tags' => true,

    /**
     * Should we prefix the git tag create upon release with a 'v'
     * i.e. '1.4.5' or 'v1.4.5'
     */
    'prefix_git_tags_with_v' => false,

    /**
     * Should staircase create a release branch in git for this new release.
     * valid values: true, false, 'production_only'.
     */
    'create_release_branch' => false,

    /**
     * Should Staircase automatically deploy after creating a new release.
     */
    'deploy_after_release' => true,

    /**
     * Used to prefix the release number for creating release branches.
     * we don't automatically add a slash, so you can use a hyphen or underscore here if you like.
     * example: {prefix}v1.2.3
     */
    'release_branch_prefix' => 'release/',

    /**
     * Used to inform staircase that this is likely a production release, you can use
     * grep pattern matching here.
     */
    'production_branch' => 'release/*',
];
