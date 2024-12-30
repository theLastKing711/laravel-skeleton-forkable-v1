<?php

namespace App\Data\Testing\Sex;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use OpenApi\Attributes as OAT;

#[TypeScript]
class Testing extends Data
{
    public function __construct()
    {

    }
}
