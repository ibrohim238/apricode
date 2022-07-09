<?php

namespace App\Versions\V1\Services;

use App\Dto\GameDto;
use App\Models\Game;
use App\Versions\V1\Repositories\GameRepository;

class GameService
{
    private GameRepository $repository;

    public function __construct(
        private Game $game
    )
    {
        $this->repository = app(GameRepository::class, [
            'game' => $this->game
        ]);
    }

    public function store(GameDto $dto): Game
    {
        $this->repository
            ->fill($dto->except('genres'))
            ->save()
            ->syncGenres($dto->genres);

        return $this->game;
    }

    public function update(GameDto $dto): Game
    {
        $this->repository
            ->fill($dto->except('genres'))
            ->save()
            ->syncGenres($dto->genres);

        return $this->game;
    }

    public function destroy(): void
    {
        $this->repository
            ->delete();
    }
}
