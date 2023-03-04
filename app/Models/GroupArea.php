<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'division_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
