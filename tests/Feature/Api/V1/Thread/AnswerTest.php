<?php

namespace Api\V1\Thread;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;
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
        $response->assertJson([
            'message' => 'answer submitted successfully'
        ]);
      $this->assertTrue($thread->answers()->where('content','foo')->exists());
    }

    public function test_update_answer_should_be_validated()
    {
        $answer = Answer::factory()->create();

        $response = $this->putJson(route('answers.update',[$answer]),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    public function test_update_own_answer_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'content'=>'foo',
            'user_id'=>$user->id
        ]);
        $response = $this->putJson(route('answers.update', [$answer]) , [
            'content' => 'bar',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer updated successfully'
        ]);

        $answer->refresh();
        $this->assertEquals('bar' , $answer->content);
    }

    public function test_delete_own_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'user_id'=>$user->id
        ]);
        $response = $this->deleteJson(route('answers.destroy', [$answer]), []);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer deleted successfully'
        ]);
        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
    }
}
