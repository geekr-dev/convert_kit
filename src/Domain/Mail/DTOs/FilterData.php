<?php

namespace Domain\Mail\DTOs;

use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public function __construct(
        private readonly array $form_ids = [],
        private readonly array $tag_ids = [],
    ) {
    }
}
