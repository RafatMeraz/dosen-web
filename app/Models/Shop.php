<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'address'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }


    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
