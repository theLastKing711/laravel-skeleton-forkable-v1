<?php

namespace App\Data\Testing;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SexData extends Data
{
    public function __construct() {}
}
