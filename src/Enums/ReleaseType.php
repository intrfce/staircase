<?php

namespace Intrfce\Staircase\Enums;

enum ReleaseType: string
{
    case Major = 'major';
    case Minor = 'minor';
    case Patch = 'patch';
}
