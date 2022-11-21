<?php

namespace Tests\Feature\Api\V1\Thread;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));

        $response->assertStatus(200);
    }

    public function test_thread_should_be_accessible_by_slug()
    {
        $thread =Thread::factory()->create();
        $response = $this->get(route('threads.show' , [$thread->slug]));
        $response->assertStatus(200);
    }
}
