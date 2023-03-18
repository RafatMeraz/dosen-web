<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    use HasJsonRelationships;


    public function users(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
//        return $this->hasMany(User::class, 'division_ids');
        return $this->hasManyJson(User::class, 'division_ids');
    }


    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
