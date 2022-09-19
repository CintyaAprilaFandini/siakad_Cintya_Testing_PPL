<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
