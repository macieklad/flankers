<?php

namespace App\Models;

use App\Traits\HasWallet;
use App\Traits\TeamMember;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use function PHPSTORM_META\map;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, HasWallet, Notifiable, TeamMember, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'pivot'
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'elo' => 'integer'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Hash user password when updating it
     *
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Return path where user avatar should be stored
     *
     * @return string
     */
    public function avatarPath()
    {
        return 'avatars/users/' . $this->id . '.jpg';
    }

    /**
     * Get default avatar url
     *
     * @return string
     */
    public function defaultAvatar()
    {
        return 'https://eu.ui-avatars.com/api/?format=png&name=flankers';
    }

    /**
     * Check if user is the game owner
     *
     * @param Game $game
     * @return boolean
     */
    public function isGameOwner(Game $game)
    {
        return $game->owner_id == $this->id;
    }
}
