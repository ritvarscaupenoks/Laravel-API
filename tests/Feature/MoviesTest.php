<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Tests\TestCase;

class MoviesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index_display_movies()
    {
        Movie::factory()->count(15)->create();

        $response = $this->get('/movies');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_show_movie_by_id()
    {
        $movie = Movie::factory()->create();
        MovieBroadcast::factory()->count(15)->create(['movie_id' => $movie->id]);

        $response = $this->get("/movies/{$movie->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'movie' => [
                'id',
                'title',
                'rating',
                'age_restriction',
                'description',
                'premieres_at',
            ],
            'broadcasts' => [
                'data' => [
                    '*' => [
                        'id',
                        'movie_id',
                        'channel_nr',
                        'broadcasts_at',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
    }

    public function test_store_movie()
    {
        $movieData = Movie::factory()->make()->toArray();

        $response = $this->postJson('/movies', $movieData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'title',
            'rating',
            'age_restriction',
            'description',
            'premieres_at',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('movies', $movieData);
    }

    public function test_add_broadcast()
    {
        $movie = Movie::factory()->create();
        $broadcastData = MovieBroadcast::factory()->make(['movie_id' => $movie->id])->toArray();

        $response = $this->postJson("/movies/{$movie->id}/broadcasts", $broadcastData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'movie_id',
            'channel_nr',
            'broadcasts_at',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('movie_broadcasts', $broadcastData);
    }

    public function test_destroy_movie()
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/movies/{$movie->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
