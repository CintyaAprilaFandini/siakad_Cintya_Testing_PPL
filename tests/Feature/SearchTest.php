<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Search()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
