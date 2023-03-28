<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class loggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $password = sha1($request->password);
        $user = User::where(['email' => $request->email, 'password' => $password, 'type' => $request->type])->first();
        if ($user) {
            return $next($request);
        }
        return response()->json('Login failed!');
    }
}
