<?php

use Intrfce\Staircase\Exceptions\UnableToParseVersionStringException;

it('parses version strings with or without the v prefix', function (string $versionString, int $major, int $minor, int $patch) {
    $parsed = \Intrfce\Staircase\Data\SemanticVersion::fromVersionString($versionString);
    expect($parsed->major)->toBe($major)
        ->and($parsed->minor)->toBe($minor)
        ->and($parsed->patch)->toBe($patch);
})
    ->with([
        ['v1.5.89', 1, 5, 89],
        ['1.5.89', 1, 5, 89],
        ['1.0.0', 1, 0, 0],
        ['0.0.2', 0, 0, 2],
        ['v0.0.3', 0, 0, 3],
    ]);

it('throws an exception when an invalid version string is supplied', function () {
    \Intrfce\Staircase\Data\SemanticVersion::fromVersionString('woopsie');
})->throws(UnableToParseVersionStringException::class);

it('throws an exception when an invalid version type is supplied to fromVersionString', function () {
    \Intrfce\Staircase\Data\SemanticVersion::fromVersionString(2242232);
})->throws(UnableToParseVersionStringException::class);

it('returns a version string when provided with the right inputs', function () {
    expect(
        (new \Intrfce\Staircase\Data\SemanticVersion(1, 2, 3))->toString()
    )->toBe('1.2.3');
});
