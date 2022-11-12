<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'remarks',
        'amount',
        'status', //pending, accpeted, rejected
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
