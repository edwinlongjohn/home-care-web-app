<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the incidents for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incedent::class)->latest();
    }

    /**
     * Get all of the incidentDetails for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidentDetails(): HasMany
    {
        return $this->hasMany(IncidentDetail::class, 'home_care_id', 'id')->latest();
    }
}
