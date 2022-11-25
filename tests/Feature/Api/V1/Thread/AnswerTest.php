<?php

namespace Api\V1\Thread;

use App\Models\Thread;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_answers_list()
    {
        $response = $this->get(route('answers.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_answer_should_be_validated()
    {
        $response = $this->postJson(route('answers.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content','thread_id']);
    }

    public function test_submit_new_answer_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store') , [
            'content' => 'foo',
            'thread_id' => $thread->id
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
      $this->assertTrue($thread->answers()->where('content','foo')->exists());
    }
}
