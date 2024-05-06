<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Location extends TestCase
{
    /** test */
    public function testloggedInUsercanbrowselocations()
    {

        $response = $this->get('/location');

        $response->assertStatus(302);
    }
}
