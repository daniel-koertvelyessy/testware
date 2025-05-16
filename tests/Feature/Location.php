<?php

namespace Tests\Feature;

use Tests\TestCase;

class Location extends TestCase
{
    /** test */
    public function testlogged_in_usercanbrowselocations()
    {

        $response = $this->get('/location');

        $response->assertStatus(302);
    }
}
