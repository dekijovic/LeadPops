<?php


namespace App\Service;


use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class JWT
{

    public const EXPIRED = 1;
    public const INVALID = 2;
    public const VALID = 3;

    private $secret = 'tokensecret';

    public function generate(User $user)
    {
        $data = [
            'user' => $user->name,
            'time' => date('Y-d-m H:i:s')
        ];
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);

        $payload = json_encode([
            'user' => $user->name,
            'exp' => microtime(true)
        ]);

        $base64UrlHeader = $this->encode($header);
        $base64UrlPayload = $this->encode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);

        $base64UrlSignature = $this->encode($signature);
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }

    public function validate($jwt)
    {
        $jwt =  explode(' ', $jwt);
        if(!count($jwt)==2 || !($jwt[0] =='Bearer')){
            return self::INVALID;
        }
        $tokenParts = explode('.', $jwt[1]);
        $header = base64_decode($tokenParts[0]);
        $payload = json_decode(base64_decode($tokenParts[1]), true);
        $signatureProvided = $tokenParts[2];

        if(!(new UserRepository())->find($payload['user'])){
            return self::INVALID;
        }

        $expiration = Carbon::createFromTimestamp($payload['exp']);

        $encodedHeader = $this->encode($header);
        $encodedPayload = $this->encode($payload);
        $signature = hash_hmac('sha256', $encodedHeader . "." . $encodedPayload, $this->secret, true);
        $base64UrlSignature = $this->encode($signature);

        if($base64UrlSignature === $signatureProvided){
          if($tokenExpired = (Carbon::now()->diffInSeconds($expiration, true) > 600)){
                return self::EXPIRED;
            }
            return self::VALID;
        } else {
            return self::INVALID;
        }


    }

    public function encode($text)
    {
        if(is_array($text)){
            $text = json_encode($text);
        }
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }
}
