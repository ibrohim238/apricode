<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\Genre;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'GenreResource',
    description: 'Genre resource',
    xml: new OA\Xml(
        name: 'GenreResource'
    )
)]
class GenreResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Genre $data;
}
