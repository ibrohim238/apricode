<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
*/
class GenreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
