<?php

namespace Intrfce\Staircase;

class Staircase
{
    public array $providedReleasePipeline = [];

    public function createReleasesUsing(array $pipeline): self
    {
        $this->providedReleasePipeline = $pipeline;

        return $this;
    }
}
