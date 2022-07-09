<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin Game
 */
class GameCollection extends ResourceCollection
{
    public $collects = GameResource::class;
}
