<?php

namespace App\Versions\V1\Http\Controllers;

use App\Dto\GameDto;
use App\Models\Game;
use App\Versions\V1\Http\Requests\GameRequest;
use App\Versions\V1\Http\Resources\GameCollection;
use App\Versions\V1\Http\Resources\GameResource;
use App\Versions\V1\Repositories\GameRepository;
use App\Versions\V1\Services\GameService;
use Illuminate\Http\Request;
use function app;
use function response;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $genres = app(GameRepository::class)
            ->paginate($request->get('count'));

        return new GameCollection($genres);
    }

    public function show(Game $game)
    {
        return new GameResource(
            app(GameRepository::class, [
                'game' => $game
            ])->getGame()
        );
    }

    public function store(GameRequest $request)
    {
        $game = app(GameService::class)
            ->store(GameDto::fromRequest($request));

        return new GameResource($game);
    }

    public function update(Game $game, GameRequest $request)
    {
        app(GameService::class, [
            'game' => $game
        ])->update(GameDto::fromRequest($request));

        return new GameResource($game);
    }

    public function destroy(Game $game)
    {
        app(GameService::class, [
            'game' => $game
        ])->destroy();

        return response()->noContent();
    }
}
