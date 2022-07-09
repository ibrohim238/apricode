<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Genre;
use App\Versions\V1\Http\Resources\GameCollection;
use App\Versions\V1\Http\Resources\GameResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameTest extends TestCase
{
    use WithFaker;

    public function testIndexOk()
    {
        $games = Game::factory()->count(5)->create()->load('genres');

        $response = $this->getJson(route('game.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new GameCollection($games))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $game = Game::factory()->create();

        $response = $this->getJson(route('game.show', $game));

        $response->assertOk()
            ->assertJsonFragment(
                (new GameResource($game))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('game.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $genres = Genre::factory()->count(5)->create();

        $response = $this->postJson(route('game.store'), [
            'name' => $this->faker->name,
            'studio' => $this->faker->company,
            'genres' => $genres->pluck('id')
        ]);

        $response->assertCreated();
    }

    public function testStoreErrorValidateStudio()
    {
        $response = $this->postJson(route('game.store'), [
            'name' => $this->faker->name,
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['studio']);
    }

    public function testUpdateOk()
    {
        $game = Game::factory()->create();

        $response = $this->patchJson(route('game.update', $game), [
            'name' => $this->faker->name,
            'studio' => $this->faker->company,
        ]);

        $response->assertOk();
    }

    public function testUpdateNotFound()
    {
        $response = $this->patchJson(route('game.update', 'n'), [
            'name' => $this->faker->name,
            'studio' => $this->faker->company,
        ]);

        $response->assertNotFound();
    }

    public function testUpdateErrorValidateName()
    {
        $game = Game::factory()->create();

        $response = $this->patchJson(route('game.update', $game), [
            'studio' => $this->faker->company,
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function testDestroyOk()
    {
        $game = Game::factory()->create();

        $response = $this->deleteJson(route('game.destroy', $game));

        $response->assertNoContent();
    }

    public function testDestroyNotFound()
    {
        $response = $this->deleteJson(route('game.destroy', 'n'));

        $response->assertNotFound();
    }
}
