<?php

namespace Domain\Mail\ViewModels\Concerns;

use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

trait HasTags
{
    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map->getData();
    }
}
