<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'shop_id',
        'image',
        'remarks'
    ];

    public function users()
    {
        return $this->hasMany(Division::class);
    }

    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
