<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\GenreRequest;

class GenreDto extends BaseDto
{
    public string $name;

    public static function fromRequest(GenreRequest $request)
    {
        return new self($request->validated());
    }
}
