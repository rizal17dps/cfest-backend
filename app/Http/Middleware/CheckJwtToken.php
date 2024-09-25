<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\ResponseFormater;

class CheckJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken(); // or $request->header('Authorization')

            if (!$token) {
                return ResponseFormater::error(401, '', 'Token not provided', 99);
            }

            $response = Http::get(env('API_GATEWAY') . '/auth/check-token', [
                'token' => $token,
            ]);

            if ($response->getStatusCode() != 200) {
                return ResponseFormater::error(401, '', 'Token is invalid', 99);
            }

            [$header, $payload, $signature] = explode('.', $token);

            $remainder = strlen($payload) % 4;
            if ($remainder) {
                $padlen = 4 - $remainder;
                $payload .= str_repeat('=', $padlen);
            }

            // Decode the payload from Base64Url
            $payload = base64_decode(strtr($payload, '-_', '+/'));
            $payloadData = json_decode($payload, true);

            $user = User::find($payloadData['sub']);
            // $userArray = $user->toJson();

            if (!$user) {
                return ResponseFormater::error(401, '', 'Token is invalid', 99);
            }

            // If token is valid, continue processing the request
            return $next($request);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }
    }
}
