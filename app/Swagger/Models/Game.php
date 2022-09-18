<?php

namespace App\Swagger\Models;

use Carbon\Carbon;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Game',
    description: 'Game Model',
    xml: new OA\Xml(
        name: 'Game'
    )
)]
class Game
{
    #[OA\Property(
        title: 'id',
        description: 'id',
        format: 'int64',
        example: 1,
    )]
    private int $id;

    #[OA\Property(
        title: 'name',
        description: 'Имя',
        example: 'Rachelle Homenick'
    )]
    public string $name;

    #[OA\Property(
        title: 'studio',
        description: 'Студия',
        example: 'Logic'
    )]
    public string $studio;

    #[OA\Property(
        title: "Created at",
        description: "Создана в",
        type: "string",
        format: "datetime",
        example: "2020-01-27 17:50:45",
    )]
    private Carbon $created_at;
}
