<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $studio
 * @property-read array $genres
*/
class GameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'studio' => ['required', 'string'],
            'genres' => ['nullable', 'array', 'exists:genres,id']
        ];
    }
}
