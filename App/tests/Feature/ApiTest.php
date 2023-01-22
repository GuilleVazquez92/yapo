<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_search_tracks()
    {
        $response = $this->get('api/search_tracks');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_fav_tracks()
    {
        $response = $this->post('api/fav');
        
        $response->assertStatus(200);
    }
}
