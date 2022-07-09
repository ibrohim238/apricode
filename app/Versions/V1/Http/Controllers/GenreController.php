<?php

namespace App\Versions\V1\Http\Controllers;

use App\Dto\GenreDto;
use App\Models\Genre;
use App\Versions\V1\Http\Requests\GenreRequest;
use App\Versions\V1\Http\Resources\GenreCollection;
use App\Versions\V1\Http\Resources\GenreResource;
use App\Versions\V1\Repositories\GenreRepository;
use App\Versions\V1\Services\GenreService;
use Illuminate\Http\Request;
use function app;
use function response;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $genres = app(GenreRepository::class)
            ->paginate($request->get('count'));

        return new GenreCollection($genres);
    }

    public function show(Genre $genre)
    {
        return new GenreResource(
            app(GenreRepository::class, [
                'genre' => $genre
            ])->getGenre()
        );
    }

    public function store(GenreRequest $request)
    {
        $genre = app(GenreService::class)
            ->store(GenreDto::fromRequest($request));

        return new GenreResource($genre);
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        app(GenreService::class, [
            'genre' => $genre
        ])->update(GenreDto::fromRequest($request));

        return new GenreResource($genre);
    }

    public function destroy(Genre $genre)
    {
        app(GenreService::class, [
            'genre' => $genre
        ])->destroy();

        return response()->noContent();
    }
}
