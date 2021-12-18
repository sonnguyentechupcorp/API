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
                'author_id' => ''

            ]);
        } catch (\Exception $e) {
            $this->assertDatabaseMissing('posts', [
                'title' => $title
            ]);
        }

        try {
            Posts::create([
                'title' => $title,
                'body' =>'cccccc',
                'author_id' => 'sadsad'

            ]);
        } catch (\Exception $e) {
            $this->assertDatabaseMissing('posts', [
                'title' => $title
            ]);
        }

    }

    public function test_update_data_to_database_success()
    {
        $post = $this->createPost();

        $this->assertModelExists($post);

        $post->update(['title' => $this->faker->title()]);

        $this->assertModelExists($post);
    }

    public function test_update_data_to_database_failed()
    {
        $post = $this->createPost();

        try {
            $updateStatus = $post->update(['title' => '']);

            $this->assertFalse($updateStatus);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

        try {
            $updateStatus = $post->update(['author_id' => '']);

            $this->assertFalse($updateStatus);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
