<?php

namespace Domain\Mail\Contracts;

use Dotenv\Util\Str;
use PhpParser\Node\Expr\Cast\String_;

interface Sendable
{
    public function id(): int;
    public function type(): string;
    public function subject(): string;
    public function content(): String;
}
