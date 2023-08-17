<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'description',
        'photos',
        'capacity',
        'cuisine',
        'user_manager',
        'latitude',
        'longitude',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $table = 'restaurents';
    public $timestamps = false;
}
