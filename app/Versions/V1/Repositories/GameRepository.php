<?php

namespace App\Versions\V1\Repositories;

use App\Dto\GameDto;
use App\Models\Game;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GameRepository
{
    public function __construct(
        private Game $game
    )
    {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->game)
            ->with('genres')
            ->allowedFilters([
                'name',
                'studio',
                AllowedFilter::exact('genres', 'genres.name')
            ])->paginate($perPage);
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function fill(GameDto $dto): static
    {
        $this->game->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->game->save();

        return $this;
    }

    public function syncGenres(?array $genres): static
    {
        app(GenreSynchronizer::class, [
            'genres' => $genres,
            'genreable' => $this->game,
        ])->sync();

        return $this;
    }

    public function delete(): static
    {
        $this->game->delete();

        return $this;
    }
}
