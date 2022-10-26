<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    const SUPER_ADMIN = 'super_admin';
    const USER        = 'user';

    protected $fillable = [
        'name',
        'email',
        'user_type',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function revisions(): HasMany
    {
        return $this->hasMany(Revision::class);
    }
}
