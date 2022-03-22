<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;


class JwtVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorizationHeader = explode(' ',$request->header('Authorization'));
        $head = isset($authorizationHeader[0]) ? $authorizationHeader[0]: false;
        $jwt = isset($authorizationHeader[1]) ? $authorizationHeader[1]: false;
        if(!$head && !$jwt){
            return response()->json([
                'status' => 0,
                'reply' => 'Geçersiz kullanıcı1!'
            ]);
        }
        try{
            $secretKey = env('JWT_SECRET');
            $decoded = JWT::decode($jwt, new Key($secretKey,'HS256'));

            $request->attributes->add(['decoded' => $decoded, 'jwt' => $jwt]);
            return $next($request);
        }
        catch (ExpiredException $e) {
            return response()->json([
                'status' => 0,
                'reply' => 'Süresi dolmuş token!'
            ], 400);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'reply' => 'Geçersiz Kullanıcı2!',
                "message" => $e->getMessage()
            ], 400);
        }
    
    }
}