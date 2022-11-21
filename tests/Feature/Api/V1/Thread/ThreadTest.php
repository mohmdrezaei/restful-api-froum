<?php

namespace Tests\Feature\Api\V1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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

    public function test_create_thread_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'));

        $response->assertStatus(422);
    }

    public function test_create_new_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('threads.store',[
            'title' => 'laravel permissions',
            'content' => 'laravel permissions laravel permissions laravel permissions laravel permissions',
            'channel_id'=>Channel::factory()->create()->id
        ]));

        $response->assertStatus(201);
    }
}
