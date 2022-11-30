<?php

namespace Api\V1\Thread;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_user_can_unsubscribe_fromphp_a_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response =$this->postJson(route('unSubscribe' , [$thread]));

        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'user unSubscribed successfully'
        ]);
    }

}
