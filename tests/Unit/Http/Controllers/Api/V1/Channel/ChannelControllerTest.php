<?php

namespace Http\Controllers\Api\V1\Channel;

use App\Models\Channel;
use Tests\TestCase;
use function route;

class ChannelControllerTest extends TestCase
{

    public function test_all_channels_list_should_be_accessible()
    {
         $response =$this->get(route('channel.all'));
         $response->assertStatus(200);
    }

    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.store'));
        $response->assertStatus(422);
    }

    public function test_create_new_channel()
    {
     $response =$this->postJson(route('channel.store' ,[
         'name'=> 'laravel'
     ]));

     $response->assertStatus(201);
    }
    public function test_channel_update_should_be_validated()
    {
        $response = $this->putJson(route('channel.update'));
        $response->assertStatus(422);
    }

    public function test_channel_update_()
    {
        $channel = Channel::factory()->create([
            'name'=>'laravel'
        ]);
        $response = $this->putJson(route('channel.update',[
            'id'=>$channel->id,
            'name'=>'vueJs'
        ]));
        $updatedChannel= Channel::find($channel->id);
        $response->assertStatus(200);
        $this->assertEquals('vueJs',$updatedChannel->name);
    }

    public function test_delete_channel()
    {
        $channel= Channel::factory()->create();
        $response = $this->deleteJson(route('channel.delete'),[
           'id'=> $channel->id
        ]);
        $response->assertStatus(200);
    }
}
