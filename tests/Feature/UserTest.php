<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_login()
    {
        $response = $this->post('/api/login');
        $response->assertStatus(200);
    }

    public function test_register()
    {
        $response = $this->post('/api/register');
        $response->assertStatus(200);
    }

}
