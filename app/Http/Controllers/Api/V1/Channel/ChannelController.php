<?php

namespace App\Http\Controllers\Api\V1\Channel;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChannelRepository;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    public function getAllChannelsList()
    {
        $all_channels = resolve(ChannelRepository::class)->all();
        return response()->json([$all_channels] , Response::HTTP_OK);
    }

    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name'=>['required']
        ]);

        resolve(ChannelRepository::class)->create($request);

        return response()->json([
           'message'=>'channel created successfully'
        ],Response::HTTP_CREATED);
    }

    public function updateChannel(Request $request )
    {
        $request->validate([
            'name'=>['required']
        ]);

        resolve(ChannelRepository::class)->update($request->id,$request->name);

        return response()->json([
            'message'=>'channel edited successfully'
        ],Response::HTTP_OK);
    }

    public function destroyChannel(Request $request)
    {
        resolve(ChannelRepository::class)->destroy($request->id);

        return response()->json([
            'message'=>'channel deleted successfully'
        ],Response::HTTP_OK);
    }




}
