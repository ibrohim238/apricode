<?php

namespace App\Traits;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasGenres
{
    public function genres(): MorphToMany
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }
}
