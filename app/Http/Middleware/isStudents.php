<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\ResponseFormater;

class isStudents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // or $request->header('Authorization')

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

        if ($user->role != 'student') {
            return ResponseFormater::error(401, '', 'Opps! You do not have permission to access', 99);
        }

        return $next($request);
    }
}
