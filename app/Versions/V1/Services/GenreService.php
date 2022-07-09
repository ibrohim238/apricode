<?php

namespace App\Versions\V1\Services;

use App\Dto\GenreDto;
use App\Models\Genre;
use App\Versions\V1\Repositories\GenreRepository;

class GenreService
{
    private GenreRepository $repository;

    public function __construct(
        private Genre $genre
    )
    {
        $this->repository = app(GenreRepository::class, [
            'genre' => $this->genre
        ]);
    }

    public function store(GenreDto $dto): Genre
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->genre;
    }

    public function update(GenreDto $dto): Genre
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->genre;
    }

    public function destroy(): void
    {
        $this->repository
            ->delete();
    }
}
