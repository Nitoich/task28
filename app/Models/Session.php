<?php

namespace App\Models;

use App\Services\JWTService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'user_id',
        'expire_date'
    ];

    public static function fastCreate(int $user_id): \Illuminate\Database\Eloquent\Builder|Model
    {
        return Session::query()->create([
            'token' => Str::random(128),
            'user_id' => $user_id,
            'expire_date' => new \DateTime('now +1month')
        ]);
    }

    public function getAccessTokenAttribute(): string
    {
        return app()->make(JWTService::class)->generate([
            'user_id' => $this->attributes['user_id'],
            'session_id' => $this->attributes['token']
        ]);
    }
}
