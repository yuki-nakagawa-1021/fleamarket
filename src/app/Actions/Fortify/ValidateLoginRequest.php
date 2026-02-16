<?php

namespace App\Actions\Fortify;

use App\Http\Requests\LoginRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateLoginRequest
{
    public function __invoke(Request $request, Closure $next)
    {
        $formRequest = app(LoginRequest::class);

        Validator::make(
            $request->all(),
            $formRequest->rules(),
            $formRequest->messages()
        )->validate();

        return $next($request);
    }
}
