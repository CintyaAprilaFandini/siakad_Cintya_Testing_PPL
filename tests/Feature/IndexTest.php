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
        $response = $this->get('mahasiswa');
        $response->assertSeeText("Email");
        $response->assertSeeText("Nim");
        $response->assertSeeText("Input Mahasiswa");
        $response->assertSeeText("Jurusan");
        $response->assertSeeText("Tanggal Lahir");
        $response->assertSeeText("Alamat");
        $response->assertStatus(200);
    }
}
