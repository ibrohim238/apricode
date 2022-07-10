<?php

namespace App\Versions\V1\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'V1 Api docs',
    title: 'Apricode documentation',
    contact: new OA\Contact(email: 'ialeroy@mail.ru'),
    license: new OA\License(name: 'Apache 2.0', url: 'https://www.apache.org/licenses/LICENSE-2.0.html')
)]
#[OA\Tag(name: 'Games', description: 'Игры')]
#[OA\Tag(name: 'Genres', description: 'Жанры')]
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
