<?php

namespace Domain\Mail\Contracts;

use Domain\Mail\DTOs\FilterData;

interface Sendable
{
    public function id(): int;
    public function type(): string;
    public function subject(): string;
    public function content(): String;
    public function filters(): FilterData;
}
