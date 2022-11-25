<?php

namespace App\Http\Controllers\Api\V1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AnswerRepository;
use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{

    public function index()
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();

        return response()->json([$answers] , Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
           'content'=>'required',
            'thread_id'=>'required'
        ]);
      resolve(AnswerRepository::class)->store($request);
        return \response()->json([] , Response::HTTP_CREATED);
    }

    public function update(Request $request, Answer $answer)
    {
        //
    }

    public function destroy(Answer $answer)
    {
        //
    }
}
