<?php

namespace App\Versions\V1\Http\Controllers;

use App\Dto\GenreDto;
use App\Models\Genre;
use App\Swagger\Responses\NotFoundResponse;
use App\Swagger\Responses\UnprocessableEntityResponse;
use App\Versions\V1\Http\Requests\GenreRequest;
use App\Versions\V1\Http\Resources\GenreCollection;
use App\Versions\V1\Http\Resources\GenreResource;
use App\Versions\V1\Repositories\GenreRepository;
use App\Versions\V1\Services\GenreService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use function app;
use function response;

class GenreController extends Controller
{
    #[OA\Get(
        path: '/api/v1/genres',
        description: 'Список жанров',
        summary: 'Список жанров',
        tags: ['Genres'],
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
        content: new OA\JsonContent(ref: "#/components/schemas/GenreResource")
    )]
    public function index(Request $request): GenreCollection
    {
        $genres = app(GenreRepository::class)
            ->paginate($request->get('count'));

        return new GenreCollection($genres);
    }

    #[OA\Get(
        path: '/api/v1/genres/{id}',
        description: 'Страница жанра',
        summary: 'Страница жанра',
        tags: ['Genres'],
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
        content: new OA\JsonContent(ref: "#/components/schemas/Genre")
    )]
    #[NotFoundResponse]
    public function show(Genre $genre): GenreResource
    {
        return new GenreResource(
            app(GenreRepository::class, [
                'genre' => $genre
            ])->getGenre()
        );
    }

    #[OA\Post(
        path: '/api/v1/genres',
        description: 'Добавить жанр',
        summary: 'Добавить жанр',
        requestBody:  new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GenreRequest'),
        ),
        tags: ['Genres']
    )]
    #[OA\Response(
        response: 201,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/Genre")
    )]
    #[UnprocessableEntityResponse]
    public function store(GenreRequest $request): GenreResource
    {
        $genre = app(GenreService::class)
            ->store(GenreDto::fromRequest($request));

        return new GenreResource($genre);
    }

    #[OA\Patch(
        path: '/api/v1/genres/{id}',
        description: 'Обновление жанра',
        summary: 'Обновление жанра',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GenreRequest'),
        ),
        tags: ['Genres'],
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
        content: new OA\JsonContent(ref: "#/components/schemas/Genre")
    )]
    #[NotFoundResponse]
    #[UnprocessableEntityResponse]
    public function update(GenreRequest $request, Genre $genre): GenreResource
    {
        app(GenreService::class, [
            'genre' => $genre
        ])->update(GenreDto::fromRequest($request));

        return new GenreResource($genre);
    }

    #[OA\Delete(
        '/api/v1/genres/{id}',
        description: 'Удаление жанра',
        summary: 'Удаление жанра',
        tags: ['Genres'],
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
    public function destroy(Genre $genre): Response
    {
        app(GenreService::class, [
            'genre' => $genre
        ])->destroy();

        return response()->noContent();
    }
}
