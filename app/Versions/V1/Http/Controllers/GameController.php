<?php

namespace App\Versions\V1\Http\Controllers;

use App\Dto\GameDto;
use App\Models\Game;
use App\Swagger\Responses\BadRequestResponse;
use App\Swagger\Responses\NotFoundResponse;
use App\Swagger\Responses\UnprocessableEntityResponse;
use App\Versions\V1\Http\Requests\GameRequest;
use App\Versions\V1\Http\Resources\GameCollection;
use App\Versions\V1\Http\Resources\GameResource;
use App\Versions\V1\Repositories\GameRepository;
use App\Versions\V1\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use function app;
use function response;

class GameController extends Controller
{
    #[OA\Get(
        path: '/api/v1/game',
        description: 'Список игр',
        summary: 'Список игр',
        tags: ['Games'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer'),
            ),
            new OA\Parameter(
                name: 'count',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer'),
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: "#/components/schemas/Game")
                ),
                new OA\Property(
                    property: 'meta',
                    ref: "#/components/schemas/Pagination"
                )
            ]
        )
    )]
    public function index(Request $request): GameCollection
    {
        $genres = app(GameRepository::class)
            ->paginate($request->get('count'));

        return new GameCollection($genres);
    }

    #[OA\Get(
        path: '/api/v1/game/{id}',
        description: 'Страница игры',
        summary: 'Страница игры',
        tags: ['Games'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1,
            )
        ],
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    ref: "#/components/schemas/Game"
                ),
            ]
        )
    )]
    #[NotFoundResponse]
    public function show(Game $game): GameResource
    {
        return new GameResource(
            app(GameRepository::class, [
                'game' => $game
            ])->getGame()
        );
    }

    #[OA\Post(
        path: '/api/v1/game',
        description: 'Добавить игру',
        summary: 'Добавить игру',
        requestBody:  new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GameRequest'),
        ),
        tags: ['Games']
    )]
    #[OA\Response(
        response: 201,
        description: 'OK',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    ref: "#/components/schemas/Game"
                ),
            ]
        )
    )]
    #[UnprocessableEntityResponse]
    public function store(GameRequest $request): GameResource
    {
        $game = app(GameService::class)
            ->store(GameDto::fromRequest($request));

        return new GameResource($game);
    }

    #[OA\Patch(
        path: '/api/v1/game/{id}',
        description: 'Обновление игры',
        summary: 'Обновление игры',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GameRequest'),
        ),
        tags: ['Games'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1,
            ),
        ],
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(properties: [
            new OA\Property(
                property: 'data',
                ref: "#/components/schemas/Game"
            ),
        ])
    )]
    #[NotFoundResponse]
    #[UnprocessableEntityResponse]
    public function update(Game $game, GameRequest $request): GameResource
    {
        app(GameService::class, [
            'game' => $game
        ])->update(GameDto::fromRequest($request));

        return new GameResource($game);
    }

    #[OA\Delete(
        '/api/v1/game/{id}',
        description: 'Удаление игры',
        summary: 'Удаление игры',
        tags: ['Games'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ]
    )]
    #[OA\Response(
        response: 204,
        description: 'OK',
        content: new OA\JsonContent()
    )]
    #[NotFoundResponse]
    public function destroy(Game $game): Response
    {
        app(GameService::class, [
            'game' => $game
        ])->destroy();

        return response()->noContent();
    }
}
