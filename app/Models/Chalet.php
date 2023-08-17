<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
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
        'rental_price',
        'available',
        'user_manager',
        'latitude',
        'longitude',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $table = 'chalets';
    public $timestamps = false;
}
