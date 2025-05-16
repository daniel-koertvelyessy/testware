<?php

namespace Tests\Feature;

use Tests\TestCase;

class checkOpenRoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_portal_is_reachable_and_renders_correctly()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeText('Dashboard');
    }

    public function test_docs_is_reachable_and_renders_correctly()
    {
        $response = $this->get('/docs');

        $response->assertStatus(200);

        $response->assertSeeText('Dokumentation');
    }

    public function test_support_is_reachable_and_renders_correctly()
    {
        $response = $this->get('/support');

        $response->assertStatus(200);

        $response->assertSeeText('Senden Sie uns Ihr Anliegen');
    }
}
