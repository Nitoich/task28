<?php

namespace App\Services;

class JWTService
{
    protected array $headers = [
        'typ' => 'JWT',
        'alg' => 'HMAC256'
    ];

    protected int $expire_minutes = 15;

    public function generate(array $payload): string
    {
        $payload['iat'] = strtotime((new \DateTime("now"))->format("Y-m-d H:i:s"));
        $payload['exp'] = strtotime((new \DateTime("now +{$this->expire_minutes} minutes"))->format("Y-m-d H:i:s"));
        $header_token = base64_encode(json_encode($this->headers));
        $payload_token = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', "$header_token.$payload_token", config("jwt.secret"));
        return "$header_token.$payload_token.$signature";
    }

    public function getPayload(string $token): ?array
    {
        $token_parts = explode('.', $token);
        if(count($token_parts) !== 3) { return null; }
        return json_decode(base64_decode($token_parts[1]), true);
    }

    public function verify(string $token): bool
    {
        $payload = $this->getPayload($token);
        if($payload === null) { return false; }
        if($payload['exp'] < strtotime((new \DateTime())->format("Y-m-d H:i:s"))) { return false; }
        $token_parts = explode('.', $token);
        $signature = hash_hmac('sha256', "$token_parts[0].$token_parts[1]", config("jwt.secret"));
        return $signature === $token_parts[2];
    }
}
