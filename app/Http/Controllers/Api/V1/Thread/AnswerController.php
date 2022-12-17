<?php

namespace App\Http\Controllers\Api\V1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AnswerRepository;
use App\Http\Repositories\SubscribeRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user-block'])->except([
            'index',
        ]);
    }

    public function index()
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();

        return response()->json([$answers], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'thread_id' => 'required'
        ]);

        // Insert data into db
        resolve(AnswerRepository::class)->store($request);

        // Get List of User Id Which To A Thread Id
        $notifiable_users_id = resolve(SubscribeRepository::class)->getNotifiableUsers($request->thread_id);

        // get user instance from id
        $notifiable_user= resolve(UserRepository::class)->find($notifiable_users_id);

        // send NewReplySubmitted notification to subscribed users
        Notification::send(User::find($notifiable_users_id), new  NewReplySubmitted(Thread::find($request->thread_id)));

        // Increase User Score
        if (Thread::find($request->input('thread_id'))->user_id !== auth()->id()){
            auth()->user()->increment('score',10);

        }

        return \response()->json([
            'message' => 'answer submitted successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'content' => 'required',
        ]);
        if (Gate::forUser(auth()->user())->allows('user_answer', $answer)) {
            resolve(AnswerRepository::class)->update($request, $answer);

            return \response()->json([
                'message' => 'answer updated successfully'
            ], Response::HTTP_OK);
        }
        return \response()->json([
            'message' => 'Access denied'
        ], Response::HTTP_FORBIDDEN);
    }

    public function destroy(Answer $answer)
    {
        if (Gate::forUser(auth()->user())->allows('user_answer',$answer)){
        resolve(AnswerRepository::class)->destroy($answer);
        return \response()->json([
            'message' => 'answer deleted successfully'
        ], Response::HTTP_OK);
        }
        return \response()->json([
            'message' => 'Access denied'
        ],Response::HTTP_FORBIDDEN);
    }
}
