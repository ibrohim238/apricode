<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Genre request',
    description: 'Genre request body data',
    required: ['name'],
    type: 'object',
)]
class GenreRequest
{
    #[OA\Property(
        title: 'name',
        description: 'Название',
        example: "A nice Genre"
    )]
    public string $name;
}
