<?php

namespace App\Data\User\Auth;

use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[OAT\Schema]
class LoginRequestData extends Data
{
    public function __construct() {}
}
