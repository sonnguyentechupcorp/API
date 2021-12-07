<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
// {
//     /**
//      * A basic unit test example.
//      *
//      * @return void
//      */
//     public function test_example()
//     {
//         $this->assertTrue(true);
//     }
// }
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_user()
    {
        $user1 = User::make([
            'name' => 'son1',
            'email' => 's1@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'son2',
            'email' => 's2@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        if ($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_stores_new_users()
    {
        $response = $this->postJson('/api/user', ['name' => 'Sally']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
    }
}
