<?php

namespace Intrfce\Staircase\Data;

use Intrfce\Staircase\Enums\ReleaseStepStatus;

class ReleaseStepResult
{
    public function __construct(
        public readonly ReleaseStepStatus $status,
        public readonly ?string $errorMessage = null,
    ) {}
}
