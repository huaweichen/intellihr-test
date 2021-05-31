<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait, SoftDeletes;

    protected $primaryKey = 'subject_id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $guarded = [];

    protected $casts = [
        'date_of_birth' => 'datetime',
        'alive' => 'boolean',
    ];

    protected $fillable = [
        'username',
        'password',
        'role',
        'test_chamber',
        'date_of_birth',
        'total_score',
        'alive',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            $user->{$user->primaryKey} = $user->role === 'GLaDOS' ? 'GLaDOS' : Str::uuid();
        });
    }
}
