<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\GameRequest;

class GameDto extends BaseDto
{
    public string $name;
    public string $studio;
    public ?array $genres;

    public static function fromRequest(GameRequest $request)
    {
        return new self($request->validated());
    }
}
