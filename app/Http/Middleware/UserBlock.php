<?php

namespace App\Http\Middleware;

use App\Http\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!resolve(UserRepository::class)->isBlock()){
            return $next($request);
        }
        return  response()->json([
            'message'=> 'you are blocked'
        ] , Response::HTTP_FORBIDDEN);


    }
}
