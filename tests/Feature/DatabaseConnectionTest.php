<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function test_database_connection()
    {
        $this->assertTrue(
            \DB::connection()->getPdo() instanceof \PDO
        );

    }
}