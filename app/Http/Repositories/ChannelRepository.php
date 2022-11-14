<?php

namespace App\Http\Repositories;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * @return void
     */
    public function all()
    {
        return Channel::all();
    }
    /**
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @return void
     */
    public function update($id ,$name): void
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    public function destroy($id): void
    {
        Channel::destroy($id);
    }
}
