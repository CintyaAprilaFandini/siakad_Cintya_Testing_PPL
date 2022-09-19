<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Khs_pdfTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Khs_pdf()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
