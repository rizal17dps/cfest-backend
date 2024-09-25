<?php

namespace App;
use App\Models\User;
/**
 * Format response.
 */
class Utils
{
    
    public static function checkUser($nim)
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

        $user = User::where('id', $payloadData['sub'])->where('username', $nim)->first();
        if(!$user){
            return false;
        }
        
        return true;
    }
    
}