<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Versions\V1\Http\Resources\GenreCollection;
use App\Versions\V1\Http\Resources\GenreResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use WithFaker;

    public function testIndexOk()
    {
        $genres = Genre::factory()->count(5)->create();

        $response = $this->getJson(route('genres.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new GenreCollection($genres))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $genre = Genre::factory()->create();

        $response = $this->getJson(route('genres.show', $genre));

        $response->assertOk()
            ->assertJsonFragment(
                (new GenreResource($genre))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('genres.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->postJson(route('genres.store'), [
            'name' => $this->faker->name,
        ]);

        $response->assertCreated();
    }

    public function testUpdateOk()
    {
        $genre = Genre::factory()->create();

        $response = $this->patchJson(route('genres.update', $genre), [
            'name' => $this->faker->name,
        ]);

        $response->assertOk();
    }

    public function testUpdateNotFound()
    {
        $response = $this->patchJson(route('genres.update', 'n'), [
            'name' => $this->faker->name,
        ]);

        $response->assertNotFound();
    }

    public function testUpdateErrorValidateName()
    {
        $genre = Genre::factory()->create();

        $response = $this->patchJson(route('genres.update', $genre));

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function testDestroyOk()
    {
        $genre = Genre::factory()->create();

        $response = $this->deleteJson(route('genres.destroy', $genre));

        $response->assertNoContent();
    }

    public function testDestroyNotFound()
    {
        $response = $this->deleteJson(route('genres.destroy', 'n'));

        $response->assertNotFound();
    }
}
