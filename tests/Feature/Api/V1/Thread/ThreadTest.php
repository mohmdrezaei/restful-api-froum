<?php

namespace Tests\Feature\Api\V1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_thread_should_be_accessible_by_slug()
    {
        $thread =Thread::factory()->create();
        $response = $this->get(route('threads.show' , [$thread->slug]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_thread_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('threads.store') ,[
        'title' => 'laravel permissions',
            'content' => 'laravel permissions laravel permissions laravel permissions laravel permissions',
            'channel_id'=>Channel::factory()->create()->id
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_update_thread_should_be_validated()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create([
            'title' => 'foo',
            'content' => 'foo',
            'channel_id'=>Channel::factory()->create()->id
        ]);
        $response = $this->putJson(route('threads.update',[$thread]) , []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }



    public function test_update_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
            'title' => 'foo',
            'content' => 'foo',
            'channel_id'=>Channel::factory()->create()->id,
            'user_id'=> $user->id
        ]);
        $response = $this->putJson(route('threads.update', [$thread]),[
            'title' => 'bar',
            'content' => 'foo',
            'channel_id'=>Channel::factory()->create()->id,
        ])->assertSuccessful();

        $thread->refresh();
        $this->assertSame('bar' , $thread->title);
    }

    public function test_can_best_answer_id_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
           'user_id'=> $user->id
        ]);
        $response = $this->putJson(route('threads.update', [$thread]),[
            'best_answer_id' => 1,
        ])->assertSuccessful();

        $thread->refresh();
        $this->assertSame( 1, $thread->best_answer_id);
    }

    public function test_delete_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
            'user_id'=> $user->id
        ]);
        $response = $this->deleteJson(route('threads.destroy', [$thread]));
        $response->assertStatus(Response::HTTP_OK);
    }
}
