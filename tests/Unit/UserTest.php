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
    // public function test_login_form()
    // {
    //     $response = $this->get('/login');
    //     $response->assertStatus(200);
    // }
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


}
