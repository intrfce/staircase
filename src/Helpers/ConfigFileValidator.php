<?php

namespace Intrfce\Staircase\Helpers;

use Illuminate\Support\Facades\Validator;
use JsonException;

class ConfigFileValidator
{
    public function isValid(string $jsonString): bool
    {
        if ($data = $this->parseValidJson($jsonString)) {
            return $this->validateConfig(
                $data
            );
        }

        return false;
    }

    private function validateConfig(array $json): bool
    {
        return Validator::make($json, [
            'version' => ['required'],
        ])->passes();
    }

    private function parseValidJson(string $json): ?array
    {
        try {
            return json_decode(json: $json, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
    }
}
