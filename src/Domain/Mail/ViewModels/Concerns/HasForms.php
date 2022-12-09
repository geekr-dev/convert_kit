<?php

namespace Domain\Mail\ViewModels\Concerns;

use Domain\Subscriber\Models\Form;
use Illuminate\Database\Eloquent\Collection;

trait HasForms
{
    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map->getData();
    }
}
