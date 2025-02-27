# Staircase

Incremental release management for Laravel following the semantic versioning standard.

Integrations with:

- Git, to tag releases, and optionally create release branches if you're following [Trunk based development]() methodology.
- Sentry, to inform it of new releases.
- Any service that supports a deployment webhook
- Multiple environments
- Custom build and release steps for any scenario.

## Get started.

Install the package:


```
composer require intrfce/staircase
```

Get started by running:

```
php artisan staircase:init
```

1. This will create a `staircase.json` file at the root of your project. As well as publishing the `staircase.php` config file, and a `StaircaseServiceProvider` provider file.
2. It will prompt you for the current major, minor, and patch versions of your app's current release if you already have a system or release number in place. This will add them to `staircase.json`.

## Run a production release.

Run `php artisan release` and choose if it's a major/minor/patch release.

Depending on your preferences set in `staircase.json`, staircase will:

- Tag your current branch with the release.
- Create a new release branch (if you have this enabled)
- Build your dependencies and create a release artifact (if this is enabled in config)
- Push your current branch/tag or new release branch to git.
- Ping your deployment hook URL if configured.

## Roadmap

- I'd love to build in some dependency switching, so when you switch branches to a branch that may have a different set of `composer` or `npm` dependencies, it would symlink or swap in those without having to re-run `composer install` or `npm install` if they're already up to date.
- Would love to support building docker images.
