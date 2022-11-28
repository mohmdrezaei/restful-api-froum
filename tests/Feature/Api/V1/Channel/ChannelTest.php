<?php

namespace Api\V1\Channel;

use App\Models\Channel;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function config;
use function route;

class ChannelTest extends TestCase
{

    public function registerRolesAndPermissions()
    {
        $roleInDatabase = Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (config('permission.default_roles') as $role)
                Role::create([
                    'name' => $role
                ]);

        }

        $permissionInDatabase = Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (config('permission.default_permissions') as $permission)
                Permission::create([
                    'name' => $permission
                ]);

        }
    }

    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_channel_should_be_validated()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $response = $this->postJson(route('channel.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->postJson(route('channel.store', [
            'name' => 'laravel'
        ]));

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_channel_update_should_be_validated()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->putJson(route('channel.update'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update_()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->putJson(route('channel.update', [
            'id' => $channel->id,
            'name' => 'vueJs'
        ]));
        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('vueJs', $updatedChannel->name);
    }

    public function test_delete_channel()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();
        $response = $this->deleteJson(route('channel.delete'), [
            'id' => $channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertTrue(Channel::where('id',$channel->id)->count() === 0);
    }
}
