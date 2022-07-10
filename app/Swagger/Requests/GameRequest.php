<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Game request',
    description: 'Game request body data',
    required: ['name', 'studio'],
    type: 'object',
)]
class GameRequest
{
    #[OA\Property(
        title: 'name',
        description: 'Название',
        example: "A nice Game"
    )]
    public string $name;

    #[OA\Property(
        title: 'studio',
        description: 'Название',
        example: "This is new Game's company"
    )]
    public string $studio;

    #[OA\Property(
        title: 'genres',
        description: 'Жанры',
        type: 'array',
        items: new OA\Items(title: 'genre.id', type: 'int'),
        example: [1,2,3],
    )]
    public array $genres;
}
