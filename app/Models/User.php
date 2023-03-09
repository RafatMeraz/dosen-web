<?php

namespace App\Models;

use App\Models\Division;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'email',
        'phone',
        'role',
        'password',
        'designation',
        'division_id',
        'status', // 1 = block,  0  = active
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'division_ids' => 'array',
    ];

    use HasJsonRelationships;


    public function visits()
    {
        return $this->hasMany(Visit::class);
    }


    public function division(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
//        return $this->belongsTo(Division::class, 'division_id');
        return $this->belongsToJson(Division::class, 'division_ids');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

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

}
