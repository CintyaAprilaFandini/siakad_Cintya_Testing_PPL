<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Create()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
