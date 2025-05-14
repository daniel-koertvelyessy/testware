<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
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

        $response->assertSeeText('Dashboard');
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




}
