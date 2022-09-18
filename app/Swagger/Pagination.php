<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Pagination',
    description: 'Pagination',
    xml: new OA\Xml(
        name: 'Pagination'
    )
)]
class Pagination
{
    #[OA\Property(
        title: 'current_page',
        description: 'current_page',
        type: 'integer'
    )]
    public int $current_page;

    #[OA\Property(
        title: 'from',
        description: 'from',
        type: 'integer'
    )]
    public int $from;

    #[OA\Property(
        title: 'last_page',
        description: 'last_page',
        type: 'integer'
    )]
    public int $last_page;

    #[OA\Property(
        title: 'path',
        description: 'path',
        type: 'string'
    )]
    public string $path;

    #[OA\Property(
        title: 'per_page',
        description: 'per_page',
        type: 'integer'
    )]
    public int $per_page;

    #[OA\Property(
        title: 'to',
        description: 'to',
        type: 'integer'
    )]
    public int $to;

    #[OA\Property(
        title: 'total',
        description: 'total',
        type: 'integer'
    )]
    public int $total;
}
