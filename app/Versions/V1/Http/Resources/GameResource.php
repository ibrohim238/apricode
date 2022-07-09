<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Game
*/
class GameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'studio' => $this->studio,
            'genres' => new GenreCollection($this->whenLoaded('genres')),
            'created_at' => $this->created_at
        ];
    }
}
