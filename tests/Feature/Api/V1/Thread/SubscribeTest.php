<?php

namespace Api\V1\Thread;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_to_a_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response =$this->postJson(route('subscribe' , [$thread]));

        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'user subscribed successfully'
        ]);
    }

    public function test_user_can_unsubscribe_from_a_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response =$this->postJson(route('unSubscribe' , [$thread]));

        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'user unSubscribed successfully'
        ]);
    }

    public function test_notification_will_send_to_subscribers_of_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();

        $thread =Thread::factory()->create();
        $subscribe_response =$this->postJson(route('subscribe' , [$thread]));
        $subscribe_response->assertSuccessful();
        $subscribe_response->assertJson([
            'message' => 'user subscribed successfully'
        ]);

        $answer_response = $this->postJson(route('answers.store'),[
            'content' => 'foo',
            'thread_id'=>$thread->id
        ]);
        $answer_response->assertSuccessful();
        $answer_response->assertJson([
            'message' => 'answer submitted successfully'
        ]);

        Notification::assertSentTo($user, NewReplySubmitted::class);
    }

}
