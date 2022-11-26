<?php

namespace App\Http\Repositories;

use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;

class AnswerRepository
{
    public function getAllAnswers()
    {
        return Answer::latest()->get();
   }

    public function store(Request $request)
    {
        Thread::find($request->thread_id)->answers()->create([
            'content'=>$request->input('content'),
            'user_id'=>auth()->id()
        ]);
   }
    public function update(Request $request , Answer $answer)
    {
        $answer->update([
            'content'=> $request->input('content'),
        ]);
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
    }

}
