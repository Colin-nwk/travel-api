<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;


    public function test_tours_by_travel_slug_returns_correct_tours(): void
    {


        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount('data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }
    public function test_tours_list_returns_pagination(): void
    {


        $toursPerPage = config('app.paginationPerPage.tours');

        $travel = Travel::factory()->create();
        Tour::factory($toursPerPage + 1)->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount($toursPerPage, 'data');
        $response->assertJsonPath('meta.current_page', 2);
    }

    public function test_tours_list_sorts_by_starting_date_correctly()
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(3),
        ]);
        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonPath('date.0.id', $earlierTour->id);
        $response->assertJsonPath('date.1.id', $laterTour->id);
    }
}
