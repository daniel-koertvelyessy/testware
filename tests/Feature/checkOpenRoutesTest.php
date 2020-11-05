<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class checkOpenRoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Portal_isReachableAndRendersCorrectly()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeText('Verwaltung');
    }

    public function test_Docs_isReachableAndRendersCorrectly() {
        $response = $this->get('/docs');

        $response->assertStatus(200);

        $response->assertSeeText('Dokumentation');
    }

    public function test_Support_isReachableAndRendersCorrectly() {
        $response = $this->get('/support');

        $response->assertStatus(200);

        $response->assertSeeText('Senden Sie uns Ihr Anliegen');
    }

    public function test_RegisterPhone_isReachableAndRendersCorrectly() {
        $response = $this->get('/registerphone');

        $response->assertStatus(200);

        $response->assertSeeText('Phono');
    }

}
