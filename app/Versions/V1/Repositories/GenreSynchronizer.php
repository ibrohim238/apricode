<?php

namespace App\Versions\V1\Repositories;

use App\Contracts\Genreable;

class GenreSynchronizer
{
    public function __construct(
        private ?array    $genres,
        private Genreable $genreable,
    )
    {
    }

    public function sync(): void
    {
        $this->genreable->genres()->sync($this->genres);
    }
}
