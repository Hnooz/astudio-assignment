<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    public function __construct(private string $apiKey = '')
    {
        $this->apiKey = is_string(config('app.api_key')) ? config('app.api_key') : '';
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Api-Key') === null || ! hash_equals((string) $request->header('Api-Key'), $this->apiKey)) {
            return new JsonResponse([
                'message' => __('messages.key Invalid'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
