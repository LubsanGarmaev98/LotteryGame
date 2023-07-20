<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\CreatedUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $attributes = [
        'is_admin' => false
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'is_admin',
        'points',
        'password',
    ];

    protected $dispatchesEvents = [
        'created' => CreatedUser::class
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin():bool
    {
        return $this->is_admin;
    }

    public function lotteryGameMatchUser(): BelongsTo
    {
        return $this->belongsTo(LotteryGameMatchUser::class);
    }

    public function lotteryGameMatch(): BelongsTo
    {
        return $this->belongsTo(LotteryGameMatch::class, 'winner_id');
    }
}
