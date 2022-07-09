<?php

namespace App\Versions\V1\Repositories;

use App\Dto\GenreDto;
use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class GenreRepository
{
    public function __construct(
        public Genre $genre
    )
    {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->genre)
            ->allowedFilters([
                'name'
            ])->paginate($perPage);
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function fill(GenreDto $dto): static
    {
        $this->genre->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->genre->save();

        return $this;
    }

    public function delete(): static
    {
        $this->genre->delete();

        return $this;
    }
}
