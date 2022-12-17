<?php

namespace App\Http\Controllers\Api\V1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ThreadRepository;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user-block'])->except([
            'index',
            'show'
        ]);
    }

    public function index()
    {
        $threads = resolve(ThreadRepository::class)->getAllAvailableThreads();
        return response()->json($threads ,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
           'title'=> 'required',
           'content'=> 'required',
           'channel_id'=> 'required'
        ]);

        resolve(ThreadRepository::class)->store($request);

        return \response()->json([
            'message' => 'Thread Created Successfully'
        ],Response::HTTP_CREATED);
    }

    public function show($slug)
    {
        $thread =resolve(ThreadRepository::class)->getThreadBySlug($slug);
        return \response()->json($thread,Response::HTTP_OK);
    }

    public function update(Thread $thread ,Request $request)
    {
       $request->has('best_answer_id')
           ? $request->validate([
               'best_answer_id'=>'required'
           ])
           : $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'channel_id'=> 'required'
        ]);

       if (Gate::forUser(auth()->user())->allows('user_thread',$thread)){
           resolve(ThreadRepository::class)->update($thread,$request);

           return \response()->json([
               'message' => 'Thread updated Successfully'
           ],Response::HTTP_OK);
       }

        return \response()->json([
            'message' => 'Access denied'
        ],Response::HTTP_FORBIDDEN);
    }
    public function destroy(Thread $thread)
    {
        if (Gate::forUser(auth()->user())->allows('user_thread',$thread)){
            resolve(ThreadRepository::class)->destroy($thread);

            return \response()->json([
                'message' => 'Thread updated Successfully'
            ],Response::HTTP_OK);
        }


        return \response()->json([
            'message' => 'access denied'
        ],Response::HTTP_FORBIDDEN);
    }
}
