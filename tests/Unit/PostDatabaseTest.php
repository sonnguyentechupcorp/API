<?php

namespace Tests\Unit;

use App\Models\Posts;
use Tests\TestCase;

class PostDatabaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function createPost()
    {
        return Posts::create([
            'title' => $this->faker->title(),
            'body' => 'abc',
            'author_id' => '1'
        ]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_insert_data_to_database_success()
    {
        $user = $this->createPost();

        $this->assertModelExists($user);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_insert_data_to_database_failed()
    {
        $title = $this->faker->title();

        try {
            Posts::create([
                'title' => $title,
                'body' =>'abc',
                'author_id' => '1'

            ]);
        } catch (\Exception $e) {
            $this->assertDatabaseMissing('posts', [
                'title' => $title
            ]);
        }

        try {
            Posts::create([
                'title' =>  $this->faker->title(),
                'body' =>'abc',
                'author_id' => ''

            ]);
        } catch (\Exception $e) {
            $this->assertDatabaseMissing('posts', [
                'author_id' => ''
            ]);
        }
    }


    //     try {
    //         User::create([
    //             'name' => $name,
    //             'email' => $this->faker->email(),
    //             'password' => '123456',
    //             'birth_date' => '',
    //             'gender' => 1,
    //             'role' => ["User"],
    //         ]);
    //     } catch (\Exception $e) {
    //         $this->assertDatabaseMissing('users', [
    //             'name' => $name
    //         ]);
    //     }

    //     try {
    //         User::create([
    //             'name' => $name,
    //             'email' => $this->faker->email(),
    //             'password' => '123456',
    //             'birth_date' => Carbon::parse('1998-10-10'),
    //             'gender' => '',
    //             'role' => ["User"],
    //         ]);
    //     } catch (\Exception $e) {
    //         $this->assertDatabaseMissing('users', [
    //             'name' => $name
    //         ]);
    //     }

    //     try {
    //         User::create([
    //             'name' => $name,
    //             'email' => '',
    //             'password' => '123456',
    //             'birth_date' => Carbon::parse('1998-10-10'),
    //             'gender' => 1,
    //             'role' => ["User"],
    //         ]);
    //     } catch (\Exception $e) {
    //         $this->assertDatabaseMissing('users', [
    //             'name' => $name
    //         ]);
    //     }


    public function test_update_data_to_database_success()
    {
        $post = $this->createPost();

        $this->assertModelExists($post);

        $post->update(['title' => $this->faker->title()]);

        $this->assertModelExists($post);
    }

    // public function test_update_data_to_database_failed()
    // {
    //     $user = $this->createUser();

    //     try {
    //         $updateStatus = $user->update(['birth_date' => '']);

    //         $this->assertFalse($updateStatus);
    //     } catch (\Exception $e) {
    //         $this->assertTrue(true);
    //     }

    //     try {
    //         $updateStatus = $user->update(['email' => '']);

    //         $this->assertFalse($updateStatus);
    //     } catch (\Exception $e) {
    //         $this->assertTrue(true);
    //     }

    //     try {
    //         $updateStatus = $user->update(['gender' => '']);

    //         $this->assertFalse($updateStatus);
    //     } catch (\Exception $e) {
    //         $this->assertTrue(true);
    //     }

}
