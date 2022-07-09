<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Genreable
{
    public function genres(): MorphToMany;
}
