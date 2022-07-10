<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\Game;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'GameResource',
    description: 'Game resource',
    xml: new OA\Xml(
        name: 'GameResource'
    )
)]
class GameResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Game $data;
}
